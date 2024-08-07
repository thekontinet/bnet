<?php

namespace Tests;

use App\Http\Middleware\DisableIfNoSubscription;
use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

abstract class TenantTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $tenancy = true;

    protected Customer|null $user = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(DisableIfNoSubscription::class);

        if ($this->tenancy) {
            $this->initializeTenancy();
        }
    }

    public function initializeTenancy(): void
    {
        $tenant = Organization::factory()->create();
        $tenant->domains()->create([
            'domain' => 'test.local'
        ]);

        URL::forceRootUrl('http://' . $tenant->domains()->first()->domain);
        Auth::setDefaultDriver('web');

        tenancy()->initialize($tenant);
    }

    public function login()
    {
        $user = Customer::factory()->create([
            'tenant_id' => tenant('id')
        ]);

        $this->actingAs($user);
        $this->user = $user;

        return $this;
    }

}
