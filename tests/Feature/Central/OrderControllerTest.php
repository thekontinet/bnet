<?php

namespace Tests\Feature\Central;

use App\Models\Order;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_order_list_page(): void
    {
        $response = $this->login()->withDomain()->get(route('order.index'));

        $response->assertStatus(200);
    }

    public function test_can_see_customers_order()
    {
        $this->login()->withDomain();

        $orders = Order::factory(10)->create([
            'tenant_id' => $this->tenant->id
        ])->sortByDesc('created_at');

        $response = $this->get(route('order.index'));

        $response->assertSeeInOrder($orders->pluck('reference')->toArray());
    }

    public function test_cannot_see_other_tenants_customers_order()
    {
        $this->login()->withDomain();

        $orders = Order::factory(10)->create([
            'tenant_id' => Organization::factory()->create()->id
        ])->sortByDesc('created_at');

        $response = $this->get(route('order.index'));

        $response->assertDontSee($orders->pluck('reference')->toArray());
    }
}
