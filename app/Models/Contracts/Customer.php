<?php

namespace App\Models\Contracts;

use Cknow\Money\Money;

interface Customer
{
    public function payments();

    public function initializePayment(Money $money);

    public function wallet();
}
