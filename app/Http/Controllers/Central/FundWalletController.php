<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FundWalletController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function index(Request $request)
    {
        //TODO: Use webhook for payment verification instead
        try {
            $reference = $request->get('reference');
            // Acquire a lock for 5 minutes
            if (!Cache::lock("payment_verification_{$reference}", 300)) {
                throw new \Exception('Payment processing');
            }

            $payment = Payment::getPendingByReference($reference);

            if(!$payment){
                throw new \Exception('Payment not approved');
            }

            if (!$this->paymentService->verifyPayment($payment)) {
                throw new \Exception('Payment pending or processed');
            }

            DB::transaction(function() use($reference, $payment){
                $payment->verify();

                auth()->user()->wallet->deposit($payment->amount->getAmount(), [
                    'description' => 'Fund wallet',
                    'payment_reference' => $reference
                ]);
            });

            return redirect('/dashboard')->with('message', 'payment successful');
        } catch (\Exception $e) {
            logger()->error('Payment confirmation failed: ' . $e->getMessage());
            return redirect('/dashboard')->with('error', 'error confirming payment');
        }
    }

    public function create()
    {
        return view('deposit.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'decimal:2', 'money', 'numeric']
        ], [
            'amount.required' => 'required',
            'amount.decimal' => 'invalid format. 2 decimal place number required'
        ]);

        $payment = auth()->user()->initializePayment(money($request->amount));

        $paymentLink = $this->paymentService->createPaymentLink($payment);

        return redirect($paymentLink);
    }
}
