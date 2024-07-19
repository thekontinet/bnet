<?php

namespace App\Http\Controllers\Central;

use App\Exceptions\AppError;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function create(Request $request)
    {
        return view('subscription.create', [
            'tenant' => $request->user(),
            'plans' => Plan::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id']
        ]);

        $plan =  Plan::find($request->get('plan_id'));
        /** @var Organization $tenant */
        $tenant = $request->user();

        try{
            DB::beginTransaction();

            $this->subscriptionService->subscribe($plan, $tenant);
            $tenant->wallet->withdraw($plan->price, [
                'description' => "New subscription: {$plan->title}"
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('message', 'Subscription successful');
        }catch (AppError|UnacceptedTransactionException $e){
            DB::rollBack();
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
