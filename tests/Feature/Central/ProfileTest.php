<?php

namespace Central;

use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this
            ->login($tenant)
            ->withDomain()
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this
            ->login($tenant)
            ->withDomain()
            ->patch('/profile', [
                'name' => 'Test User',
                'username' => 'testuser',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $tenant->refresh();

        $this->assertSame('Test User', $tenant->name);
        $this->assertSame('test@example.com', $tenant->email);
        $this->assertNull($tenant->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this
            ->login($tenant)
            ->withDomain()
            ->patch('/profile', [
                'name' => 'Test User',
                'username' => 'testuser',
                'email' => $tenant->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($tenant->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this
            ->login($tenant)
            ->withDomain()
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($tenant->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $tenant = Organization::factory()->create();

        $response = $this
            ->login($tenant)
            ->withDomain()
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($tenant->fresh());
    }
}
