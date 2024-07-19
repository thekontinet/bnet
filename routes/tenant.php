<?php

declare(strict_types=1);

use App\Http\Controllers\Shared\HandlePaymentController;
use App\Http\Controllers\Shared\VerifyPaymentController;
use App\Http\Controllers\Tenant\Authentication\PasswordController;
use App\Http\Controllers\Tenant\Authentication\TenantAuthenticatedSessionController;
use App\Http\Controllers\Tenant\Authentication\TenantRegisterController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\OrderController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Tenant\RechargeServiceController;
use App\Http\Controllers\Tenant\Services\AirtimeServiceController;
use App\Http\Controllers\Tenant\Services\DataServiceController;
use App\Http\Controllers\Tenant\SettingsController;
use App\Http\Controllers\Tenant\TransactionController;
use App\Http\Middleware\DisableIfNoSubscription;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


/*
|--------------------------------------------------------------------------
| Organization Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->name('tenant.')->group(function () {
    Route::get('/', function () {
        return view('template::auth.login');
    })->middleware('guest:web');

    Route::middleware(['auth:web', DisableIfNoSubscription::class])->group(function(){
        // TODO: Sync tenant settings from database into config file
        // TODO: Add middleware to force email verification
        // TODO: Add feature to handle refund on refund recharge using webhook
        
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::post('/pay', HandlePaymentController::class)->name('payment.new');
        Route::get('/pay/{payment:reference}', VerifyPaymentController::class)->name('payment.verify');

        Route::get('/settings', SettingsController::class)->name('setting.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/password', [PasswordController::class, 'update'])->name('password.update');
        Route::post('/logout', [TenantAuthenticatedSessionController::class, 'destroy'])->name('logout');;

        Route::resource('airtime', AirtimeServiceController::class)->only(['create', 'store']);
        Route::resource('data-plan', DataServiceController::class)->only(['create', 'store']);

        Route::get('/services/{service}', [RechargeServiceController::class, 'create'])->name('service.purchase');
        Route::post('/package/{package}', [RechargeServiceController::class, 'update'])->name('package.purchase');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transaction.index');
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    });

    Route::middleware(['guest:web', DisableIfNoSubscription::class])->group(function(){
        Route::get('/register', [TenantRegisterController::class, 'create'])->name('register');
        Route::post('/register', [TenantRegisterController::class, 'store']);
        Route::get('/login', [TenantAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [TenantAuthenticatedSessionController::class, 'store']);
    });


    Route::post('order-item/{item}/delivery', \App\Http\Controllers\Shared\OrderCallbackController::class)
    ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
    ->name('order.check');

    // TODO: Password Reset for customers
    // TODO: Email Verification for customers
});
