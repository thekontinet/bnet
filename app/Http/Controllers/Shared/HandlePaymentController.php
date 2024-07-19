<?php

namespace App\Http\Controllers\Shared;

use App\Exceptions\Payments\GatewayError;
use App\Http\Controllers\Controller;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class HandlePaymentController extends Controller
{

    public function __invoke(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'decimal:2', 'money', 'numeric', 'min:50']
        ], [
            'amount.required' => 'required',
            'amount.decimal' => 'invalid format. 2 decimal place number required'
        ]);

        try {
            $paymentService = PaymentService::use(Paystack::class);

            $payment = $paymentService->createPayment($request->user(), $request->amount, 'paystack');

            $callback_url = match (is_null(tenant())){
                true => route('payment.confirm', ['payment' => $payment->reference]),
                false => route('tenant.payment.verify', ['payment' => $payment->reference]),
            };

            $paymentUrl = $paymentService
                ->generatePaymentLink($payment, $callback_url);

            return redirect($paymentUrl);
        }catch (GatewayError $e) {
            return redirect()->back()->withErrors(['amount' => $e->getMessage()]);
        }
    }
}
