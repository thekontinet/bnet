<?php

namespace Central;

use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this->post('/login', [
            'email' => $tenant->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $tenant = Organization::factory()->create();

        $this->post('/login', [
            'email' => $tenant->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this->actingAs($tenant)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
