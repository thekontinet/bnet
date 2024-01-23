<?php

namespace Tests\Feature\Services;

use App\Models\Package;
use App\Models\Tenant;
use App\Services\PackageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;

class PackageServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_package_to_tenant()
    {
        $fixedPackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_FIXED]);
        $discountPackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_DISCOUNT]);
        $tenant = Tenant::factory()->create();
        $packageService = new PackageService();

        // Add a new package to the tenant
        $packageService->addPackageToTenant($fixedPackage, $tenant);
        $packageService->addPackageToTenant($discountPackage, $tenant);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $fixedPackage->id,
            'price' => $fixedPackage->price,
        ]);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $discountPackage->id,
            'discount' => $discountPackage->discount,
        ]);
    }

    public function test_update_existing_package_with_new_price()
    {
        $fixedPackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_FIXED]);
        $discountPackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_DISCOUNT]);
        $tenant = Tenant::factory()->create();
        $packageService = new PackageService();

        // Add a new package to the tenant
        $packageService->addPackageToTenant($fixedPackage, $tenant);
        $packageService->addPackageToTenant($discountPackage, $tenant);

        // Update the existing package with a new price
        $packageService->addPackageToTenant($fixedPackage, $tenant, '50', true);
        $packageService->addPackageToTenant($discountPackage, $tenant, '5', true);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $fixedPackage->id,
            'price' => '50',
        ]);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $discountPackage->id,
            'discount' => '5',
        ]);
    }

    public function test_add_packages_to_tenant()
    {
        $packages = Package::factory(3)->create();
        $tenant = Tenant::factory()->create();
        $prices = [
            $packages[0]->id => '50',
            $packages[1]->id => '75',
            $packages[2]->id => '100',
        ];
        $packageService = new PackageService();

        // Add multiple packages to the tenant
        $packageService->addPackagesToTenant($packages, $tenant, $prices);

        foreach ($packages as $package) {
            $this->assertDatabaseHas('tenant_package', [
                'tenant_id' => $tenant->id,
                'package_id' => $package->id,
            ]);
        }
    }

    public function test_sync_tenant_packages()
    {
        $tenant = Tenant::factory()->create();
        $fixedPricePackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_FIXED]);
        $discountPackage = Package::factory()->create(['price_type' => Package::PRICE_TYPE_DISCOUNT]);
        $packageService = new PackageService();

        // Sync all packages to the tenant
        $packageService->syncTenantPackages($tenant);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $fixedPricePackage->id,
            'price' => $fixedPricePackage->price,
        ]);

        $this->assertDatabaseHas('tenant_package', [
            'tenant_id' => $tenant->id,
            'package_id' => $discountPackage->id,
            'discount' => $discountPackage->discount,
        ]);
    }
}
