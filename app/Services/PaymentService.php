<?php

namespace App\Services;

use App\Models\Payment;
use App\Services\Gateways\Paystack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new Paystack(config('services.paystack.secret_key'));
    }

    public function createPaymentLink(Payment $payment): string
    {
        try {
            return $this->gateway->createPaymentLink(
                $payment->amount->getAmount(),
                $payment->payable->email,
                $payment->reference,
                route('deposit.confirm'));
        } catch (\Exception $e) {
            logger()->error("Payment link creation failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function verifyPayment(Payment $payment): bool
    {
        try {
            if($this->gateway->verifyPayment($payment->reference)){
                return true;
            }
            return false;
        } catch (\Exception $e) {
            logger()->error("Payment verification failed: {$e->getMessage()}");
            throw $e;
        }
    }
}
