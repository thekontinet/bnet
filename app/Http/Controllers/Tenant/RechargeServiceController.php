<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\ServiceEnum;
use App\Http\Controllers\BaseTenantController;
use App\Jobs\ProcessOrder;
use App\Models\Package;
use App\Services\OrderService;
use App\Services\VirtualTopupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mockery\Exception;

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
    public function update(Request $request, Package $package, OrderService $orderService)
    {
        $package->tenants()->findOrFail(tenant('id'));

        /**
         * Find the processor for the service and run
         * validation for  the service requirements
         */
        $processor = $package->service->getPackageManger();
        $validated = $request->validate($processor->rules());

        $order = DB::transaction(function() use ($orderService, $package, $validated){
            $order = $orderService->create($package, Auth::user(), money(request()->get('amount'))->getAmount(), $validated);
            $orderService->processPayment($order);
            return $order;
        });
        ProcessOrder::dispatch($order);

        return redirect()->route('tenant.dashboard')->with('message', 'Order submitted for delivery');
    }
}
