<?php

namespace App\Services;

use App\Enums\ServiceEnum;
use App\Models\Package;
use App\Models\Tenant;
use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\Contracts\PackageManager;
use App\Services\VtuProviders\DataPackageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VirtualTopupService
{
    private PackageManager $packageManger;

    private ServiceEnum $service;

    public function __construct(ServiceEnum $service)
    {
        $this->service = $service;
        $this->packageManger = $service->getPackageManger();
    }

    public function uploadPackages(): void
    {
        $packagesArray =  $this->packageManger->getPackages();
        Package::query()->where('service', $this->service)->delete();
        foreach ($packagesArray as $packageData){
            Package::query()->firstOrCreate($packageData);
        }
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate($this->packageManger->rules());
    }

    public function subscribe(Package $package, array $params): array
    {
        Validator::make($params, $this->packageManger->rules());
        return $this->packageManger->handleDelivery($package, $params);
    }
}
