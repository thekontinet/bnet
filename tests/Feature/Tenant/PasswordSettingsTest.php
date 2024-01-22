<?php

namespace Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TenantTestCase;
use Tests\TestCase;

class PasswordSettingsTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_account_settings_page(): void
    {
        $response = $this->login()->get(route('tenant.setting.edit', 'security'));

        $response->assertStatus(200);
    }

    public function test_can_update_account_info(): void
    {
        $response = $this->login()->post(route('tenant.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $customer = auth()->user();

        $this->assertTrue(Hash::check('new-password', $customer->password));
    }
}
