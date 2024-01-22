<?php

namespace App\Providers;

use App\Enums\Config;
use App\Exceptions\PaymentError;
use App\Models\Customer;
use App\Models\Tenant;
use App\Services\Gateways\Contracts\Gateway;
use App\Services\Gateways\Paystack;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(resource_path('templates/default/components'), 'tenant');
        $this->loadViewsFrom(resource_path('templates/default'), 'template');
        Schema::defaultStringLength(191);

        app()->singleton(Gateway::class, function($app){
            return new Paystack;
        });
    }

}
