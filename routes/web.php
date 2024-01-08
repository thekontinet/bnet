<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\FundWalletController;
use App\Http\Controllers\Central\ProfileController;
use App\Http\Controllers\Central\ServiceController;
use App\Http\Controllers\Central\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
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
});

require __DIR__.'/auth.php';
