<?php

namespace App\Http\Controllers\Shared;

use App\Exceptions\PaymentError;
use App\Exceptions\Payments\GatewayError;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyPaymentController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(Request $request, Payment $payment)
    {
        //TODO: Use webhook for payment verification instead

        try {
            PaymentService::use(Paystack::class)
                ->validatePayment($payment);

            DB::transaction(function () use ($payment) {
                $payment->verify();
                $payment->payable->wallet->deposit($payment->amount, [
                    'description' => 'Wallet deposit',
                ]);
            });

            return redirect('/dashboard')->with('message', 'payment successful');
        } catch (GatewayError $e) {
            logger()->error("Gateway error: " . $e->getMessage(), ['payment_id' => $payment->id]);
            return redirect('/dashboard')->with('error', $e->getMessage());
        } catch (PaymentError $e) {
            logger()->error("Payment error: " . $e->getMessage(), ['payment_id' => $payment->id]);
            return redirect('/dashboard')->with('error', 'Payment could not be validated');
        }catch (\Exception $e) {
            logger()->critical("Unexpected error: " . $e->getMessage(), ['payment_id' => $payment->id]);

            return redirect('/dashboard')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
