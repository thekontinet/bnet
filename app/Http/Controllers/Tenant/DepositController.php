<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\Config;
use App\Exceptions\AppError;
use App\Exceptions\PaymentError;
use App\Http\Controllers\BaseTenantController;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Organization;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class DepositController extends BaseTenantController
{
    public function __invoke()
    {
        return $this->view('deposit.form');
    }
}
