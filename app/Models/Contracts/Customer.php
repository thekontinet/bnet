<?php

namespace App\Models\Contracts;

use App\Models\Transaction;
use Cknow\Money\Money;

interface Customer
{
    public function payments();

    public function initializePayment(Money $money);

    public function wallet();

    public function pay(Product $product): Transaction;
}
