<?php

namespace Tests\Feature\Central;

use App\Enums\ServiceEnum;
use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_service_list_page(): void
    {
        $response = $this->login()
            ->withDomain()->get(route('services.index'));

        $response->assertStatus(200);
        $response->assertSee(
            collect(ServiceEnum::cases())
                ->pluck('value')
                ->map('strtoupper')
                ->toArray()
        );
    }

    public function test_can_render_provider_list_page(): void
    {
        $packages = Package::factory(5)->create([
            'service' => ServiceEnum::DATA
        ]);

        $response = $this->login()
            ->withDomain()->get(route('services.show', ServiceEnum::DATA));

        $response->assertStatus(200);
        $response->assertSee($packages->pluck('provider')->map('strtoupper')->toArray());
    }

    public function test_can_render_packages_edit_page(): void
    {
        $packages = Package::factory(5)->create([
            'price_type' => Package::PRICE_TYPE_FIXED,
            'provider' => 'test',
            'service' => ServiceEnum::DATA
        ]);

        $this->login()->withDomain();

        // Load all package into tenant package list
        (new PackageService())->addPackagesToTenant(
            $packages,
            $this->tenant,
            $packages->pluck('price', 'id')->toArray()
        );

        $this->tenant->packages()->sync($packages);
        $response = $this->get(route('services.edit', ['service' => ServiceEnum::DATA, 'provider' => 'test']));

        $response->assertStatus(200);
        $response->assertSee($packages->pluck('label')->toArray(), false);
    }

    public function test_can_update_package_price()
    {
        $package = Package::factory()->create([
            'price_type' => Package::PRICE_TYPE_FIXED,
            'provider' => 'test',
            'service' => ServiceEnum::DATA
        ]);
        $this->login()->withDomain();

        // Load all package into tenant package list
        (new PackageService())->addPackageToTenant(
            $package,
            $this->tenant,
            0
        );

        $response = $this->post(route('services.update'), [
            'fixed' => [
                $package->id => '100.00'
            ]
        ]);


        $response->assertSessionHas('message');
        $this->assertDatabaseHas('tenant_package', [
            'package_id' => $package->getKey(),
            'tenant_id' => $this->tenant->getKey(),
            'price' => 10000
        ]);
    }

    public function test_validate_fixed_price_package()
    {
        $response = $this->login()->withDomain()->post(route('services.update'), [
            'fixed' => [
                1 => '100'
            ]
        ]);

        $response->assertSessionHasErrors('fixed.1');
    }

    public function test_validate_discount_price_package()
    {
        $response = $this->login()->withDomain()->post(route('services.update'), [
            'discount' => [
                1 => '100.00'
            ]
        ]);

        $response->assertSessionHasErrors('discount.1');
    }
}
