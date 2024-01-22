<?php

use App\Http\Controllers\Central\CustomerController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\DomainController;
use App\Http\Controllers\Central\FundWalletController;
use App\Http\Controllers\Central\OrdersController;
use App\Http\Controllers\Central\ProfileController;
use App\Http\Controllers\Central\ServiceController;
use App\Http\Controllers\Central\SettingsController;
use App\Http\Controllers\Central\SubscriptionController;
use App\Http\Controllers\Central\WebsiteController;
use App\Http\Middleware\MustCompleteRequiredSetup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');;

//TODO: Test MustCompleteRequiredSetup::class middleware
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', MustCompleteRequiredSetup::class])
    ->name('dashboard');

// TODO: Force tenant to upload one payment option before activating account
Route::middleware([
    'auth'
])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::post('/services/{service}', [ServiceController::class, 'update'])->name('services.update');

    Route::get('/fund', [FundWalletController::class, 'create'])->name('deposit.create');
    Route::post('/fund', [FundWalletController::class, 'store'])->name('deposit.pay');
    Route::get('/fund/verify', [FundWalletController::class, 'index'])->name('deposit.confirm');

    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');

    Route::get('/orders', [OrdersController::class, 'index'])->name('order.index');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');

    Route::get('sites', [WebsiteController::class, 'edit'])->name('site');
    Route::post('sites', [WebsiteController::class, 'update']);

    Route::post('domains', [DomainController::class, 'store'])->name('domain');
    Route::put('domains', [DomainController::class, 'update']);

    Route::get('/settings/{type}', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
