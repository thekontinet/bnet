<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id']
        ]);

        try {
            $plan =  Plan::find($request->get('plan_id'));

            //TODO: Add a feature where remaining days for previous plan is added to new plan if old plan hasnt expired
            $this->subscriptionService->subscribe($plan);

            return redirect()->back()->with('message', 'Subscription successful');
        }catch (UnacceptedTransactionException $e){
            return back()->with('error', $e->getMessage());
        }catch (\Exception $exception){
            logger()->error('Subscription failed: ' .  $exception->getMessage());
            return back()->with('error', 'Subscription failed. Please try again');
        }
    }
}
