<?php

namespace App\Http\Controllers\Central\Services;

use App\Enums\ServiceEnum;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AirtimeController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user();

        /** @var Service $tenantService */
        $tenantService = Service::tenant($tenant, ServiceEnum::AIRTIME)->first();
        /** @var Service $service */
        $service = Service::central(ServiceEnum::AIRTIME)->first();

        $packages = $service->getPackages();
        $tenantPackage = $tenantService?->getPackages();

        // Return the view with the necessary data
        return view('service.airtime', [
            'packages' => $packages,
            'tenant_package' => $tenantService ? $tenantPackage : $packages,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount' => ['required', 'array'],
            'discount.*' => ['required', 'numeric', 'min:0'],
        ], [
            'discount.*.required' => 'Discount is required',
            'discount.*.numeric' => 'Discount must be numeric',
            'discount.*.min' => 'The discount must be at least 0',
        ]);

        /** @var Service $service */
        $service = Service::central(ServiceEnum::AIRTIME)->first();
        $packages = $service->data->toArray();

        foreach ($request->discount as $id => $discount){
            $packages[$id]['discount'] = $discount;
        }


        Service::upsertServiceData(
            ServiceEnum::AIRTIME,
            $packages,
            $request->user(),
            $service
        );

        Service::upsertServiceData(
            ServiceEnum::AIRTIME,
            $packages,
            $request->user(),
            $service
        );

        return back()->with(['message' => 'Airtime service updated']);
    }
}
