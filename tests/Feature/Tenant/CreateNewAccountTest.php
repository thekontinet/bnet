<?php

namespace Tests\Feature\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TenantTestCase;
use Tests\TestCase;

class CreateNewAccountTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_register_page(): void
    {
        $response = $this->get(route('tenant.register'));
        $response->assertStatus(200);
    }

    public function test_can_create_new_account(): void
    {
        $response = $this->post(route('tenant.register'), [
            'firstname' => 'Test Firstname',
            'lastname' => 'Test Lastname',
            'username' => 'app1',
            'phone' => '09000000000',
            'email' => 'email@fake.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('tenant.dashboard'));
    }
}
