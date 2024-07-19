<?php

namespace App\Http\Controllers\Central\Services;

use App\Enums\ServiceEnum;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class DataPlanController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user();

        /** @var Service $tenantService */
        $tenantService = Service::tenant($tenant, ServiceEnum::DATA)->first();
        /** @var Service $service */
        $service = Service::central(ServiceEnum::DATA)->first();

        $packages = $service->getPackages();
        $tenantPackage = $tenantService?->getPackages();

        // Return the view with the necessary data
        return view('service.data', [
            'provider' => $request->query('network') ?? 'mtn',
            'packages' => $packages,
            'tenant_package' => $tenantService ? $tenantPackage : $packages,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prices' => ['required', 'array'],
            'prices.*' => ['required', 'numeric', 'min:0'],
        ], [
            'prices.*.required' => 'Discount is required',
            'prices.*.numeric' => 'Discount must be numeric',
            'prices.*.min' => 'The discount must be at least 0',
        ]);

        /** @var Service $service */
        $service = Service::central(ServiceEnum::DATA)->first();
        $packages = $service->data->toArray();

        foreach ($request->prices as $id => $price){
            $packages[$id]['price'] = $price * 100;
        }


        Service::upsertServiceData(
            ServiceEnum::DATA,
            $packages,
            $request->user(),
            $service
        );

        return back()->with(['message' => 'Data service updated']);
    }
}
