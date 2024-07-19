<?php

namespace Tests\Feature\Central;

use App\Services\DomainService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Stancl\Tenancy\Contracts\Domain;
use Tests\TestCase;

class DomainCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_domain_creation_form(): void
    {
        $response = $this->login()->get(route('domain.create'));

        $response->assertStatus(200);
    }

    public function test_cannot_render_domain_creation_form_if_tenant_has_domain(): void
    {
        $this->login();
        $this->tenant->createDomain('example.test');
        $response = $this->get(route('domain.create'));
        $response->assertStatus(403);
    }

    public function test_can_register_new_domain()
    {
        $this->login();
        $this->post(route('domain.store'), [
            'domain' => 'domain'
        ]);

        $this->assertDatabaseHas('domains', [
            'tenant_id' => $this->tenant->id,
            'domain' => 'domain' . config('app.default_domain_extension')
        ]);
    }

    public function test_cannot_register_new_domain_if_tenant_has_domain()
    {
        $this->login();
        $this->tenant->createDomain('example.test');
        $this->post(route('domain.store'), [
            'domain' => 'domain'
        ])->assertStatus(403);
    }

    public function test_only_accept_names_without_top_level_domain()
    {
        $this->login();
        $this->post(route('domain.store'), [
            'domain' => 'domain.test'
        ])->assertSessionHasErrors('domain', errorBag: 'domainCreated');
    }

    public function test_can_register_domain_that_is_not_available()
    {
        $this->login();
        $this->partialMock(DomainService::class)
            ->shouldReceive('checkAvailability')
            ->andReturn(false);
        $this->post(route('domain.store'), [
            'domain' => 'domain'
        ])->assertSessionHasErrors('domain', errorBag: 'domainCreated');

        $this->assertDatabaseEmpty('domains');
    }
}
