<?php

namespace App\Http\Controllers\Central;

use App\Enums\Config;
use App\Exceptions\AppError;
use App\Exceptions\PaymentError;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Tenant;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class FundWalletController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function index(Request $request)
    {
        //TODO: Use webhook for payment verification instead
        try {
            $this->paymentService->verifyPaymentFromRequest($request);
            return redirect('/dashboard')->with('message', 'payment successful');
        } catch (AppError $e) {
            return redirect('/dashboard')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard')->with('error', 'Payment verification failed');
        }
    }

    public function create()
    {
        return view('deposit.form');
    }

    public function store(Request $request)
    {
        $paymentLink = $this->paymentService->createPaymentLinkFromRequest($request);

        return redirect($paymentLink);
    }
}
