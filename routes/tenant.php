<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Authentication\PasswordController;
use App\Http\Controllers\Tenant\Authentication\TenantAuthenticatedSessionController;
use App\Http\Controllers\Tenant\Authentication\TenantRegisterController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\FundWalletController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Tenant\RechargeServiceController;
use App\Http\Controllers\Tenant\SettingsController;
use App\Http\Controllers\Tenant\TransactionController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
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
])->group(function () {
    Route::get('/', function () {
        return view('template::auth.login');
    })->middleware('guest:web');

    Route::middleware('auth:web')->name('tenant.')->group(function(){
        // TODO: Add middleware to force email verification
        // TODO: Add middleware to prevent customers from accessing website if tenant has no active plan
        // TODO: Add feature to handle refund on refund recharge using webhook
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/fund', [FundWalletController::class, 'create'])->name('deposit');
        Route::post('/fund', [FundWalletController::class, 'store'])->name('deposit');
        Route::get('/fund/verify', [FundWalletController::class, 'index'])->name('deposit.verify');

        Route::get('/settings', [SettingsController::class, 'index'])->name('setting.index');
        Route::get('/settings/{settings}', [SettingsController::class, 'edit'])->name('setting.edit');

        Route::get('/services/{service}', [RechargeServiceController::class, 'create'])->name('service.purchase');
        Route::post('/package/{package}', [RechargeServiceController::class, 'update'])->name('package.purchase');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transaction.index');

        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/password', [PasswordController::class, 'update'])->name('password.update');
        Route::post('/logout', [TenantAuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

    Route::middleware('guest:web')->name('tenant.')->group(function(){
        Route::get('/register', [TenantRegisterController::class, 'create'])->name('register');
        Route::post('/register', [TenantRegisterController::class, 'store']);
        Route::get('/login', [TenantAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [TenantAuthenticatedSessionController::class, 'store']);
    });

    // TODO: Password Reset for customers
    // TODO: Email Verification for customers
});
