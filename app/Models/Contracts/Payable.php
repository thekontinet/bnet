<?php

namespace App\Models\Contracts;

use App\Models\Payment;
use Illuminate\Support\Str;
use Cknow\Money\Money;

trait Payable
{
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function initializePayment(Money $money)
    {
        return $this->payments()->create([
            'tenant_id' => tenant('id'),
            'reference' => uniqid(time() . Str::random(4), true),
            'amount' => $money->getAmount(),
            'status' => Payment::STATUS_PENDING,
            'gateway' => 'paystack'
        ]);
    }
}
