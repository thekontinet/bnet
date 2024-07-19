<?php

namespace App\Models\Contracts;

use App\Models\Transaction;
use App\Models\Wallet;
use Cknow\Money\Money;

/**
 * @property Wallet $wallet
 * */
interface Customer
{
    public function payments();

    public function wallet();

    public function pay(Product $product): Transaction;
}
