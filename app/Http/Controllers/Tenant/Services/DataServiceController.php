<?php

namespace App\Http\Controllers\Tenant\Services;

use App\DataObjects\DataPlanPackageData;
use App\Enums\ServiceEnum;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Stancl\Tenancy\Contracts\Tenant;

class DataServiceController extends Controller
{
    public function store(Request $request, Tenant $tenant, OrderService $orderService)
    {
        /** @var Service $service */
        $service = Service::tenant($tenant, ServiceEnum::DATA)->first();
        $packages = collect($service->data)->groupBy('id');

        $data = $request->validate([
            'package_code' => ['required', 'string', Rule::in($packages->keys())],
            'phone' => ['required', 'max:16'],
        ]);

        $package = DataPlanPackageData::fromArray($packages->get($request->package_code)->first());

        try{

            DB::beginTransaction();
            $order = $orderService->create($request->user());

            $orderService->addItems(
                $order,
                $service,
                $package->price,
                platform_amount: $package->main_price,
                attributes: $data
            );

            $orderService->handleOrderPayment($order);

            ProcessOrder::dispatch($order);

            DB::commit();
            return redirect('dashboard')->with('message', 'Data purchase successful');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request, Tenant $tenant)
    {
        /** @var Service $service */
        $service = Service::tenant($tenant, ServiceEnum::DATA)->first();

        abort_unless($service !== null, 503, 'This service is unavailable');

        $packages = collect($service->data)->groupBy('provider');

        return view('template::service.data', [
            'packages' => $packages
        ]);
    }
}
