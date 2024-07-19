<?php

namespace Tests;

use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public ?Organization $tenant = null;

    public function createTenant()
    {
        if($this->tenant?->exists) {
            return $this->tenant;
        }

        $this->tenant = Organization::factory()->create();

        return $this;
    }

    public function withDomain()
    {
        $this->createTenant();

        $this->tenant->createDomain('example.test');
        return $this;
    }

    public function login(?Organization $user = null)
    {
        if($user){
            $this->tenant = $user;
        }

        $this->createTenant();
        $this->actingAs($this->tenant);

        return $this;
    }
}
