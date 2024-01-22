<?php

namespace Tests\Feature\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TenantTestCase;
use Tests\TestCase;

class AccountSettingsTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_account_settings_page(): void
    {
        $response = $this->login()->get(route('tenant.setting.edit', 'account'));

        $response->assertStatus(200);
    }

    public function test_can_update_account_info(): void
    {
        $response = $this->login()->post(route('tenant.profile.update'), [
            'firstname' => 'Test Firstname',
            'lastname' => 'Test Lastname',
            'phone' => '090000000000',
        ]);

        $response->assertRedirect();
        $customer = auth()->user();

        $this->assertEquals($customer->firstname, 'Test Firstname');
        $this->assertEquals($customer->lastname, 'Test Lastname');
        $this->assertEquals($customer->phone, '090000000000');
    }
}
