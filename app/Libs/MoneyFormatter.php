<?php

namespace App\Libs;

use Money\Money;

class MoneyFormatter implements \Money\MoneyFormatter
{
    public function format(Money $money): string
    {
        return '₦' . number_format($money->getAmount() / 100, 2);
    }
}
