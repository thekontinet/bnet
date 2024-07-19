<?php

namespace App\Services;

use App\Exceptions\PaymentError;
use App\Exceptions\Payments\GatewayError;
use App\Models\Contracts\Customer;
use App\Models\Payment;
use App\Services\Gateways\Contracts\Gateway;
use Illuminate\Support\Str;

class PaymentService
{
    private function __construct(private readonly Gateway $gateway)
    {
    }

    /**
     * @throws GatewayError
     */
    public static function use(Gateway | string $gateway): static
    {
        if(is_string($gateway)){
            $gateway = app($gateway);
        }

        if($gateway instanceof Gateway){
            return new static($gateway);
        }

        throw new GatewayError('Cannot use provided gateway');
    }

    public function createPayment(Customer $user, float | int $amount, string $gateway)
    {
        return $user->payments()->create([
            'organization_id' => tenant('id'), // this will be null if payment is from central domain
            'reference' => time() . Str::random(4),
            'amount' => intval($amount * 100),
            'status' => Payment::StatusPending,
            'gateway' => $this->gateway::class
        ]);
    }

    /**
     * @throws GatewayError
     */
    public function generatePaymentLink(Payment $payment, $callback_url): string
    {
        return $this->gateway->createPaymentLink(
          $payment->amount,
          $payment->payable->email,
          $payment->reference,
          $callback_url
        );
    }


    /**
     * @throws GatewayError
     * @throws PaymentError
     */
    public function validatePayment(Payment $payment): bool
    {
        if($payment->isPaid()){
            throw new PaymentError();
        }

        $paymentData = $this->gateway->getPaymentInfo($payment->reference);

        if ($paymentData->reference !== $payment->reference) {
            logger()->error("Payment reference mismatch. Expected: {$payment->reference}, got: {$paymentData->reference}");
            throw new PaymentError();
        }

        if ($paymentData->amount !== $payment->amount) {
            logger()->error("Payment amount mismatch. Expected: {$payment->amount}, got: {$paymentData->amount}");
            throw new PaymentError();
        }

        if ($paymentData->status !== true) {
            logger()->error("Payment status is not successful for reference: {$payment->reference}");
            throw new PaymentError();
        }

        return true;
    }
}
