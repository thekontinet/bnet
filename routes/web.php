<?php

use App\Http\Controllers\Central\BusinessController;
use App\Http\Controllers\Central\CustomerController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\DepositController;
use App\Http\Controllers\Central\DomainController;
use App\Http\Controllers\Central\OrdersController;
use App\Http\Controllers\Central\OrganizationController;
use App\Http\Controllers\Central\ProfileController;
use App\Http\Controllers\Central\ServiceController;
use App\Http\Controllers\Central\Services\AirtimeController;
use App\Http\Controllers\Central\Services\DataPlanController;
use App\Http\Controllers\Central\SettingsController;
use App\Http\Controllers\Central\SubscriptionController;
use App\Http\Controllers\Central\TransactionController;
use App\Http\Controllers\Shared\HandlePaymentController;
use App\Http\Controllers\Shared\VerifyPaymentController;
use App\Http\Middleware\OrganizationMustHaveDomain;
use Illuminate\Support\Facades\Route;

/**
 * TODO: Account setting
 * Work on the organization setting work flow. The organization and profile should
 * be updated separately.
 * It should also be created separately during registration
 */

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth'
])->group(function(){
    Route::resource('organizations', OrganizationController::class);
    Route::resource('domains', DomainController::class)->only('store');
});

Route::middleware([
    'auth',
    'verified',
    OrganizationMustHaveDomain::class
])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    Route::get('/business', [BusinessController::class, 'edit'])->name('business');
    Route::post('/business', [BusinessController::class, 'update']);

    Route::get('/settings/{type}', [SettingsController::class, 'edit'])->name('settings.edit')
        ->whereIn('type', \App\Enums\TenantSettingsType::all());
    Route::post('/settings/{type}', [SettingsController::class, 'update'])->name('settings.update')
        ->whereIn('type', \App\Enums\TenantSettingsType::all());

    Route::get('/deposit', DepositController::class)->name('deposit');
    Route::post('/payment', HandlePaymentController::class)->name('payment');
    Route::get('/payment/{payment:reference}', VerifyPaymentController::class)->name('payment.confirm');

    Route::get('/orders', [OrdersController::class, 'index'])->name('order.index');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transaction.index');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::resource('services/airtime', AirtimeController::class)->only(['index', 'store']);
    Route::resource('services/data', DataPlanController::class)->only(['index', 'store']);

    Route::get('/subscribe', [SubscriptionController::class, 'create'])->name('subscribe.create');
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
