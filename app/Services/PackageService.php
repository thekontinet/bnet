<?php

namespace App\Services;

use App\Enums\ServiceEnum;
use App\Models\Package;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class PackageService
{
    public function syncTenantPackages(Tenant $tenant)
    {
        return Package::all()->each(fn(Package $package) => $package->tenants()->where('id', Auth::id())->sync([
            $tenant->id => [
                'price' => $package->price,
                'discount' => $package->discount
            ]
        ]));
    }

    public function updateTenantPackages(Tenant $tenant, array $data)
    {
        return Package::whereIn('id', array_keys($data))
            ->get()
            ->each(function(Package $package) use($tenant, $data){
                $package->tenants()->where('id', $tenant->id)->sync([
                    $tenant->id => [
                        'price' => $package->price_type == Package::PRICE_TYPE_FIXED ? $data[$package->id] : $package->price,
                        'discount' => $package->price_type == Package::PRICE_TYPE_DISCOUNT ? $data[$package->id] : $package->discount,
                    ]]);
            });
    }
}
