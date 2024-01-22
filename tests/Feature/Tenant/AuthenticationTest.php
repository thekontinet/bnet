<?php

namespace Tests\Feature\Tenant;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TenantTestCase;

class AuthenticationTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_login_page(): void
    {
        $response = $this->get(route('tenant.login'));

        $response->assertStatus(200);
    }

    public function test_can_authenticate_customer()
    {
        $customer = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);

        $this->post(route('tenant.login'), [
            'email' => $customer->email,
            'password' => 'password'
        ])->assertRedirect(route('tenant.dashboard'));

        $this->assertAuthenticated();
    }
}
