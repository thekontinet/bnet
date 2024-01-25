<?php

namespace Tests\Feature\Tenant;

use App\Enums\ErrorCode;
use App\Enums\ServiceEnum;
use App\Models\Package;
use App\Services\VirtualTopupService;
use App\Services\VtuProviders\FakePackageManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TenantTestCase;

class PackagePurchaseTest extends TenantTestCase
{
    use RefreshDatabase;

    private $userWalletBalance = 10000;
    private $tenantWalletBalance = 10000;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake(function () {
            return ['status' => 'success'];
        });

        $this->login();
        auth()->user()->wallet->deposit($this->userWalletBalance);
        tenant()->wallet->deposit($this->tenantWalletBalance);
    }

    private function createPackage($service, $price, $discount, $priceType)
    {
        return Package::factory()->create([
            'service' => $service,
            'price' => $price,
            'discount' => $discount,
            'price_type' => $priceType,
        ]);
    }

    private function purchasePackage($package, $data)
    {
        return $this->post(route('tenant.package.purchase', $package), $data);
    }

    private function assertBalancesAfterPurchase($userBalance, $tenantBalance): void
    {
        auth()->user()->refresh();
        tenant()->refresh();

        $this->assertEquals((int) auth()->user()->wallet->balance, $userBalance);
        $this->assertEquals((int) tenant()->wallet->balance, $tenantBalance);
    }

    public function test_can_purchase_discount_price_package()
    {
        $package = $this->createPackage(ServiceEnum::AIRTIME, 0, '0.02', Package::PRICE_TYPE_DISCOUNT);
        tenant()->packages()->attach($package, ['discount' => '0.02', 'price' => 0]);

        $response = $this->purchasePackage($package, [
            'amount' => '50.00',
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);

        $this->assertBalancesAfterPurchase($this->userWalletBalance - $package->getPrice(auth()->user()), $this->tenantWalletBalance - $package->getPrice(tenant()));

        $response->assertRedirect()->assertSessionHas('message');
    }

    public function test_can_purchase_fixed_price_package()
    {
        $package = $this->createPackage(ServiceEnum::DATA, 100.00, '0', Package::PRICE_TYPE_FIXED);
        tenant()->packages()->attach($package, ['price' => 200.00]);

        $response = $this->purchasePackage($package, [
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);

        $this->assertBalancesAfterPurchase($this->userWalletBalance - 200, $this->tenantWalletBalance - 100);

        $response->assertRedirect()->assertSessionHas('message');
    }

    public function test_cannot_purchase_package_if_not_available()
    {
        $package = $this->createPackage(
            ServiceEnum::DATA,
            100.00,
            '0',
            Package::PRICE_TYPE_FIXED);
        $package->update(['active' => false]);

        tenant()->packages()->attach($package, ['price' => 200.00]);

        $this->withoutExceptionHandling()
            ->expectExceptionCode(ErrorCode::ORDER_PROCESSING_FAILED);

        $response = $this->purchasePackage($package, [
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);

        $response->assertRedirect()->assertSessionHas('error');
    }

    public function test_purchase_fails_with_insufficient_user_balance()
    {
        $package = $this->createPackage(ServiceEnum::AIRTIME, 0, '0.02', Package::PRICE_TYPE_DISCOUNT);
        tenant()->packages()->attach($package, ['discount' => '0.02', 'price' => 0]);

        // Set user wallet balance to an insufficient amount
        auth()->user()->wallet->setBalance(0);

        $response = $this->purchasePackage($package, [
            'amount' => '50.00',
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);


        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertBalancesAfterPurchase(0, $this->tenantWalletBalance);
    }

    public function test_purchase_fails_with_insufficient_tenant_balance()
    {
        $package = $this->createPackage(ServiceEnum::AIRTIME, 0, '0.02', Package::PRICE_TYPE_DISCOUNT);
        tenant()->packages()->attach($package, ['discount' => '0.02', 'price' => 0]);

        // Set user wallet balance to an insufficient amount
        tenant()->wallet->setBalance(0);

        $response = $this->purchasePackage($package, [
            'amount' => '50.00',
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);


        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertBalancesAfterPurchase($this->userWalletBalance, 0);
    }

    public function test_user_refunded_if_order_delivery_fails()
    {
        $package = $this->createPackage(ServiceEnum::AIRTIME, 0, '0.02', Package::PRICE_TYPE_DISCOUNT);
        tenant()->packages()->attach($package, ['discount' => '0.02', 'price' => 0]);


        $this->partialMock(FakePackageManager::class)
            ->shouldReceive('handleDelivery')
            ->andThrow(\Exception::class, code: ErrorCode::DELIVERY_FAILED);

        $response = $this->purchasePackage($package, [
            'amount' => '50.00',
            'phone' => '0900000000',
            'package_id' => $package->id,
        ]);


        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertBalancesAfterPurchase($this->userWalletBalance, $this->tenantWalletBalance);
    }
}
