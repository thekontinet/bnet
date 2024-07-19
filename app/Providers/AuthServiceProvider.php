<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\Config;
use App\Exceptions\PaymentError;
use App\Models\Customer;
use App\Models\Organization;
use App\Policies\DomainPolicy;
use App\Services\Gateways\Contracts\Gateway;
use App\Services\Gateways\Paystack;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Database\Models\Domain;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
