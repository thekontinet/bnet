<?php

namespace App\Http\Controllers\Central;

use App\Enums\Config;
use App\Exceptions\AppError;
use App\Exceptions\PaymentError;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Organization;
use App\Services\Gateways\Contracts\Gateway;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __invoke()
    {
        return view('deposit.form');
    }
}
