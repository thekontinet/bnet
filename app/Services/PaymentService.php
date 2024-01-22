<?php

namespace App\Services;

use App\Exceptions\PaymentError;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Tenant;
use App\Services\Gateways\Contracts\Gateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    private $gateway;

    /**
     * @throws PaymentError
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function createPaymentLinkFromRequest(Request $request): string
    {
        if(!$this->gateway->isReady()) throw new PaymentError('Payment gateway not available');

        $request->validate([
            'amount' => ['required', 'decimal:2', 'money', 'numeric']
        ], [
            'amount.required' => 'required',
            'amount.decimal' => 'invalid format. 2 decimal place number required'
        ]);

        $payment = $request->user()->initializePayment(money($request->amount));

        return $this->gateway->createPaymentLink(
            $payment->amount->getAmount(),
            $request->user()->email,
            $payment->reference,
            $this->getCallbackUrl($payment)
        );
    }

    /**
     * @throws Exception
     */
    public function verifyPaymentFromRequest(Request $request): void
    {
        if(!$this->gateway->isReady()) throw new PaymentError('Payment gateway not available');

        $reference = $request->get('reference');

        $payment = Payment::getPendingByReference($reference);

        if(!$payment){
            throw new PaymentError('Invalid payment reference');
        }

        if (!$this->gateway->verifyPayment($payment->reference)) {
            throw new PaymentError('Payment verification failed');
        }

        DB::transaction(function() use($payment){
            $payment->verify();

            $payment->payable->wallet->deposit($payment->amount->getAmount(), [
                'description' => 'Fund wallet',
                'payment_reference' => $payment->reference
            ]);
        });

    }

    private function getCallbackUrl(Payment $payment): string
    {
        return match ($payment->payable::class){
            Customer::class => route('tenant.deposit.verify'),
            Tenant::class => route('deposit.confirm'),
            default => null
        };
    }
}
