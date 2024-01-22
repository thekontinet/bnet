<?php

namespace App\Models\Contracts;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

trait HasWallet
{
    /**
     * Retrieve the balance of this user's wallet
     */
    public function getBalanceAttribute()
    {
        return $this->wallet->refresh()->balance;
    }

    /**
     * Retrieve the wallet of this user
     */
    public function wallet()
    {
        return $this->morphOne(config('wallet.wallet_model'), 'owner')->withDefault();
    }

    /**
     * Retrieve all transactions of this user
     */
    public function walletTransactions()
    {
        return $this->hasManyThrough(
            config('wallet.transaction_model'),
            config('wallet.wallet_model'),
            'owner_id',
            'wallet_id'
        )->where('owner_type', static::class)->whereHas('wallet', function ($query) {
            $query->whereNull('deleted_at');
        })->latest();
    }
}
