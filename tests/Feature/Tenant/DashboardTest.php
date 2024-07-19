<?php

namespace Tests\Feature\Tenant;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TenantTestCase;
use Tests\TestCase;

class DashboardTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_dashboard(): void
    {
        $this->login();

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('template::dashboard');
    }

    public function test_user_can_see_thier_transactions(): void
    {
        $this->login();
        $this->user->wallet->deposit(100);

        $response = $this->get('/dashboard');
        $response->assertSee($this->user->walletTransactions->pluck('amount')->toArray());
    }
}
