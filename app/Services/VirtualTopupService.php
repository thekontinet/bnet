<?php

namespace App\Services;

use App\Enums\ServiceEnum;
use App\Models\Package;
use App\Models\Tenant;
use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\Contracts\PackageManager;
use App\Services\VtuProviders\DataPackageManager;

class VirtualTopupService
{
    private PackageManager $provider;

    private ServiceEnum $service;

    public function __construct(ServiceEnum $service)
    {
        $this->service = $service;
        $this->provider = $service->processor();
    }

    public function uploadPackages(): void
    {
        $packagesArray =  $this->provider->getPackages();
        Package::query()->where('service', $this->service)->delete();
        foreach ($packagesArray as $packageData){
            Package::query()->firstOrCreate($packageData);
        }
    }
}
