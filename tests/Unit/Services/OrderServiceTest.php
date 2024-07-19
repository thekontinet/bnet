<?php

namespace Tests\Unit\Services;

use App\Enums\StatusEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Models\Organization;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;
use Tests\TenantTestCase;
use Tests\TestCase;

class OrderServiceTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_create_new_order_for_fixed_product(): void
    {
        $orderService = new OrderService();
        $package = Package::factory()->create([
            'price_type' => Package::PRICE_TYPE_FIXED,
            'price' => 100
        ]);
        $customer = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);
        tenant()->packages()->attach($package, ['price' => 200]);

        $orderService->create($package, $customer);
        $this->assertDatabaseHas('orders', [
            'owner_type' => Customer::class,
            'owner_id' => $customer->getKey(),
            'tenant_id' => \tenant('id'),
            'purchase_price' => 100,
            'sale_price' => 200,
            'purchase_discount' => 0,
            'sale_discount' => 0,
        ]);
    }

    public function test_can_create_new_order_for_discount_product(): void
    {
        $orderService = new OrderService();
        $package = Package::factory()->create([
            'price_type' => Package::PRICE_TYPE_DISCOUNT,
            'price' => 0,
            'discount' => 2,
        ]);
        $customer = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);
        tenant()->packages()->attach($package, ['price' => 0, 'discount' => 1]);

        $orderService->create($package, $customer, 100);
        $this->assertDatabaseHas('orders', [
            'owner_type' => Customer::class,
            'owner_id' => $customer->getKey(),
            'tenant_id' => \tenant('id'),
            'purchase_price' => 100,
            'sale_price' => 100,
            'purchase_discount' => 2,
            'sale_discount' => 1,
        ]);
    }

    public function test_cannot_create_order_if_product_is_not_active(): void
    {
        $orderService = new OrderService();
        $package = Package::factory()->create([
            'price_type' => Package::PRICE_TYPE_DISCOUNT,
            'price' => 0,
            'active' => false,
        ]);
        $customer = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);
        tenant()->packages()->attach($package, ['price' => 0, 'discount' => 1]);

        $this->expectException(\Exception::class);
        $orderService->create($package, $customer, 100);
    }

    public function test_cannot_create_order_if_product_is_not_available_in_tenant_product_list(): void
    {
        $orderService = new OrderService();
        $package = Package::factory()->create([
            'price_type' => Package::PRICE_TYPE_DISCOUNT,
            'price' => 0,
        ]);
        $customer = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);

        $this->expectException(\Exception::class);
        $orderService->create($package, $customer, 100);
    }

    /**
     * @throws UnacceptedTransactionException
     * @throws \Exception
     */
    public function test_can_process_order_payment()
    {
        $orderService = new OrderService();
        $order = Order::factory()->create([
            'tenant_id' => \tenant('id'),
            'owner_type' => Customer::class,
            'owner_id' => Customer::factory()->create([
                'tenant_id' => \tenant('id')
            ])
        ]);


        $order->owner->wallet->deposit(10000);
        \tenant()->wallet->deposit(10000);


        $orderService->processPayment($order);
        \tenant()->refresh();

        $this->assertEquals($order->owner->wallet->balance, 10000 - $order->getSalesTotal());
        $this->assertEquals(\tenant()->wallet->balance, 10000 - $order->getPurchaseTotal());
    }

    /**
     * @throws UnacceptedTransactionException
     * @throws \Exception
     */
    public function test_can_process_order_refund()
    {
        $orderService = new OrderService();
        $order = Order::factory()->create([
            'tenant_id' => \tenant('id'),
            'owner_type' => Customer::class,
            'owner_id' => Customer::factory()->create([
                'tenant_id' => \tenant('id')
            ]),
            'status' => StatusEnum::PAID
        ]);


        $orderService->processRefund($order);
        \tenant()->refresh();

        $this->assertEquals($order->owner->wallet->balance, $order->getSalesTotal());
        $this->assertEquals(\tenant()->wallet->balance, $order->getPurchaseTotal());
    }

    /**
     * @throws UnacceptedTransactionException
     * @throws \Exception
     */
    public function test_cannot_process_order_refund_if_order_is_not_marked_as_paid()
    {
        $orderService = new OrderService();
        $order = Order::factory()->create([
            'tenant_id' => \tenant('id'),
            'owner_type' => Customer::class,
            'owner_id' => Customer::factory()->create([
                'tenant_id' => \tenant('id')
            ]),
        ]);

        $orderService->processRefund($order);
        \tenant()->refresh();

        $this->assertEquals($order->owner->wallet->balance, 0);
        $this->assertEquals(\tenant()->wallet->balance, 0);
    }

    //TODO: Write test for handle delivery
}
