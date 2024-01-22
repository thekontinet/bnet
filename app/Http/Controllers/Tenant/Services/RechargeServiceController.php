<?php

namespace App\Http\Controllers\Tenant\Services;

use App\Enums\ErrorCode;
use App\Enums\ServiceEnum;
use App\Http\Controllers\BaseTenantController;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Services\OrderService;
use App\Services\VirtualTopupService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;

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
        $request->validate([
            'package_id' => [
                'required',
                Rule::exists('tenant_package', 'package_id')
                    ->where('tenant_id', tenant('id'))
            ]
        ]);

        /**
         * TODO: add feature to help switch a service on or off so
         * TODO: user cannot purchase if its off
         */

        $package = tenant()->packages()->find($request->get('package_id'));
        $customer = $request->user();

        $processor = ServiceEnum::tryFrom($package->service->value)->processor();
        $order = $orderService->create($package, $customer, $request->validate($processor->rules()));

        //TODO: Dispatch these to jobs
        $orderService->processPaymentAndDeliver($order);

        return redirect()->route('tenant.dashboard')->with('message', 'airtime purchase success');
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request, Package $package, OrderService $orderService)
    {
//        $package->tenants()->findOrFail(tenant('id'));

        /**
         * TODO: add feature to help switch a service on or off so
         * TODO: user cannot purchase if its off
         */

        $customer = $request->user();

        $processor = ServiceEnum::tryFrom($package->service->value)->processor();

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
