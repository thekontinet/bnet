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
}
