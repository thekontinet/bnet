<?php

namespace Tests\Feature\Central;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Organization;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_subscription_page()
    {
        $plans = Plan::factory( 10)->create();
        $this->login()->withDomain();
        $response = $this->get(route('subscribe.create'));
        $response->assertSeeTextInOrder($plans->pluck('title')->toArray());
    }

    public function test_can_subscribe_to_plan()
    {
        $plan = Plan::factory()->create([
            'price' => 100
        ]);
        $this->login()->withDomain();
        $this->tenant->wallet->deposit(10000);

        $response = $this->post(route('subscribe.store'),[
            'plan_id' => $plan->id
        ]);

        $this->assertEquals($this->tenant->subscription?->plan_id, $plan->id);
        $response->assertRedirect();
    }

    public function test_can_debit_subscription_amount_from_wallet()
    {
        $plan = Plan::factory()->create([
            'price' => 100
        ]);

        $this->login()->withDomain();
        $this->tenant->wallet->deposit(1000);

        $response = $this->post(route('subscribe.store'),[
            'plan_id' => $plan->id
        ]);

        $this->assertEquals($this->tenant->wallet->balance, 900);
    }

    public function test_cannot_subscribe_to_plan_with_insufficent_wallet_balance()
    {
        $plan = Plan::factory()->create([
            'price' => 100
        ]);

        $this->login()->withDomain();

        $response = $this->post(route('subscribe.store'),[
            'plan_id' => $plan->id
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(auth()->user()->subscription);
    }

    public function test_cannot_subscribe_to_same_plan_if_old_plan_still_active()
    {
        $plan = Plan::factory()->create([
            'price' => 100
        ]);
        $this->login()->withDomain();
        $this->tenant->wallet->deposit(1000);
        (new SubscriptionService())->subscribe($plan, $this->tenant);

        $response = $this->post(route('subscribe.store'),[
            'plan_id' => $plan->id
        ]);

        $this->tenant->refresh();

        $response->assertSessionHas('error');
        $this->assertEquals(1000, $this->tenant->wallet->balance);
        $this->assertEquals($plan->id, $this->tenant->subscription->plan_id);
    }
}


