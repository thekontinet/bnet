<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\ServiceEnum;
use App\Http\Controllers\BaseTenantController;
use App\Models\Package;
use App\Services\OrderService;
use App\Services\VirtualTopupService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RechargeServiceController extends BaseTenantController
{
    public function index()
    {
        //
    }

    public function create(ServiceEnum $service)
    {
        return $this->view("service.$service->value", [
            'packages' => tenant()->packages()->where('service', $service)->get(),
        ]);
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request, OrderService $orderService)
    {
        // Validate the incoming request data
        $request->validate([
            'package_id' => [
                'required',
                Rule::exists('tenant_package', 'package_id')
                    ->where('tenant_id', tenant('id'))
            ]
        ]);

        /**
         * TODO: Add feature to help switch a service on or off so
         * TODO: users cannot purchase if it's off.
         */

        $package = tenant()->packages()->find($request->input('package_id'));

        if (!$package) {
            return redirect()->route('tenant.dashboard')->with('error', 'Invalid package selected.');
        }

        // Get the authenticated customer
        $customer = $request->user();

        // Create an instance of VirtualTopupService based on the selected package's service
        $vtuService = app(VirtualTopupService::class, [$package->service]);

        try {
            $order = $orderService->create($package, $customer, $request->validate($request->all()));
            $orderService->processPaymentAndDeliver($order);

            // TODO: Dispatch these to jobs
            // $orderService->processPaymentAndDeliver($order);

            // Redirect to the tenant's dashboard with a success message
            return redirect()->route('tenant.dashboard')->with('success', 'Airtime purchase success.');
        } catch (\Exception $e) {
            // Handle exceptions, log the error, and provide user-friendly feedback
            return redirect()->route('tenant.dashboard')->with('error', 'An error occurred during the purchase process.');
        }
    }


    /**
     * @throws \Exception
     */
    public function update(Request $request, Package $package, OrderService $orderService)
    {
        $package->tenants()->findOrFail(tenant('id'));

        /**
         * TODO: add feature to help switch a service on or off so
         * TODO: user cannot purchase if its off
         */

        $customer = $request->user();

        $processor = ServiceEnum::tryFrom($package->service->value)->getPackageManger();

        $order = $orderService->create($package, $customer, $request->validate($processor->rules()));

        try {
            //TODO: Dispatch these to jobs
            $orderService->processPaymentAndDeliver($order);

            return redirect()->route('tenant.dashboard')->with('message', 'airtime purchase success');
        }catch (\Exception $e){
            logger()->error($e->getMessage());
            return redirect('/dashboard')->with('error', $e->getCode() > 0 ? $e->getMessage() : 'Package purchase failed');
        }
    }
}
