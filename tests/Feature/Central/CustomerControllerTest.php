<?php

namespace Tests\Feature\Central;

use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_list_of_customers(): void
    {
        $response = $this->login()->withDomain()->get(route('customer.index'));

        $response->assertStatus(200);
    }

    public function test_tenant_can_see_thier_customers(): void
    {
        $this->login()->withDomain();
        $customers = Customer::factory(10)->create([
            'tenant_id' => $this->tenant->id
        ]);
        $response = $this->get(route('customer.index'));
        $response->assertSeeInOrder($customers->pluck('email')->toArray());
    }

    public function test_cannot_see_other_tenant_customers(): void
    {
        $this->login()->withDomain();
        $customers = Customer::factory(10)->create([
            'tenant_id' => Organization::factory()->create()->id
        ]);
        $response = $this->get(route('customer.index'));
        $response->assertDontSee($customers->pluck('email')->toArray());
    }

    public function test_can_credit_customer_wallet(): void
    {
        $this->login()->withDomain();
        $customer = Customer::factory()->create([
            'tenant_id' => $this->tenant->id
        ]);

        $response = $this->post(route('customer.update', $customer), [
            'type' => 'deposit',
            'amount' => '1000.00',
            'description' => 'test description'
        ]);

        $customer->refresh();

        $response->assertRedirect()->assertSessionHas('message');
        $this->assertEquals(100000, $customer->wallet->balance);
    }

    public function test_can_credit_another_tenant_customer_wallet(): void
    {
        $this->login()->withDomain();
        $customer = Customer::factory()->create([
            'tenant_id' => Organization::factory()->create()->id
        ]);

        $response = $this->post(route('customer.update', $customer), [
            'type' => 'deposit',
            'amount' => '1000.00',
            'description' => 'test description'
        ]);

        $customer->refresh();

        $response->assertUnauthorized();
        $this->assertEquals(0, $customer->wallet->balance);
    }
}
