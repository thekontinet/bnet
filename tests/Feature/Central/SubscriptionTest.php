<?php

namespace Tests\Feature\Central;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_subscribe_to_plan(): void
    {
        $tenant = Tenant::factory()->create();
        $tenant->wallet->deposit(100000);

        $plan = Plan::factory()->create([
            'price' => 100.00
        ]);

        $response = $this->actingAs($tenant)
            ->from(route('profile.edit'))
            ->post(route('subscribe.store'), [
                'plan_id' => $plan->id
            ]);

        $tenant->refresh();

        $this->assertNotNull($tenant->subscription);
        $this->assertEquals($tenant->wallet->balance, 90000);
    }

    public function test_cannot_subscribe_if_balance_is_insufficent(): void
    {
        $tenant = Tenant::factory()->create();

        $plan = Plan::factory()->create([
            'price' => 100.00
        ]);

        $response = $this->actingAs($tenant)
            ->from(route('profile.edit'))
            ->post(route('subscribe.store'), [
                'plan_id' => $plan->id
            ]);

        $tenant->refresh();

        $response->assertSessionHas('error');
        $this->assertNull($tenant->subscription);
    }
}


