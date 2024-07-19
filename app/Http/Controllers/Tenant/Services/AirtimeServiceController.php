<?php

namespace App\Http\Controllers\Tenant\Services;

use App\DataObjects\AirtimePackageData;
use App\Enums\ServiceEnum;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Stancl\Tenancy\Contracts\Tenant;

class AirtimeServiceController extends Controller
{
    public function store(Request $request, Tenant $tenant, OrderService $orderService)
    {
        /** @var Service $service */
        $service = Service::tenant($tenant, ServiceEnum::AIRTIME)->firstOrFail();
        $packages = collect($service->data)->groupBy('provider');

        $data = $request->validate([
            'provider' => ['required', Rule::in($packages->keys())],
            'amount' => ['required', 'numeric', 'min:50'],
            'phone' => ['required', 'max:16'],
        ]);

        $package = AirtimePackageData::fromArray($packages->get($request->provider)->first());

        try{
            $customerAmount = bcsub($request->amount, bcmul($request->amount, bcdiv($package->discount, '100', 2), 2), 2);
            $tenantAmount = bcsub($request->amount, bcmul($request->amount, bcdiv($package->main_discount, '100', 2), 2), 2);

            DB::beginTransaction();
            $order = $orderService->create($request->user());

            $orderService->addItems(
                $order,
                $service,
                $customerAmount * 100,
                platform_amount: $tenantAmount * 100,
                attributes: $data
            );

            $orderService->handleOrderPayment($order);

            ProcessOrder::dispatch($order);

            DB::commit();
            return redirect('dashboard')->with('message', 'Airtime purchase successful');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request, Tenant $tenant)
    {
        /** @var Service $service */
        $service = Service::tenant($tenant, ServiceEnum::AIRTIME)->first();

        abort_unless($service !== null, 503, 'This service is unavailable');

        $providers = collect($service->data)->pluck('provider', 'image');

        return view('template::service.airtime', [
            'providers' => $providers
        ]);
    }
}
