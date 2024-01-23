<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Tenant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PackageService
{
    /**
     * Add package to the tenant package list. If update is true it will update the tenant
     * package price if the package already exist
     * @param Package $package
     * @param Tenant $tenant
     * @param string|null $price
     * @param bool $update
     * @return void
     */
    public function addPackageToTenant(Package $package, Tenant $tenant, ?string $price = null, bool $update = false): void
    {
        if(!is_null($price) && !is_numeric($price)) throw new InvalidArgumentException('Invalid price provided');

        $packageExists = $tenant->packages()->where($package->getForeignKey(), $package->getKey())->exists();

        if($packageExists && !$update) return;

        $data = [];

        if($package->price_type == Package::PRICE_TYPE_FIXED){
            $data['price'] = $price ? money($price)->getAmount() : $package->price;
            $data['discount'] = $package->discount;
        }

        if($package->price_type == Package::PRICE_TYPE_DISCOUNT){
            $data['discount'] = $price ?? $package->discount;
            $data['price'] = $package->price;
        }

        if(!$packageExists){
            $tenant->packages()->attach($package, $data);
            return;
        }

        if($update){
            $tenant->packages()->updateExistingPivot($package->getKey(), $data);
        }
    }

    public function addPackagesToTenant(Collection $packages, Tenant $tenant, array $prices, bool $update = false): void
    {
        DB::transaction(function () use($update, $tenant, $packages, $prices){
            foreach ($packages as $package){
                $this->addPackageToTenant($package, $tenant, $prices[$package->id], $update);
            }
        });
    }

    public function syncTenantPackages(Tenant $tenant): void
    {
        DB::transaction(function() use($tenant){
            $packages = Package::all();
            foreach ($packages as $package){
                $this->addPackageToTenant(
                    $package,
                    $tenant,
                    $package->isFixedPriceType() ? $package->price : $package->discount
                );
            }
        });
    }
}
