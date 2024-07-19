<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;

class TransactionController extends BaseTenantController
{
    public function index()
    {
        return view('template::transaction',[
            'transactions' => auth()->user()->walletTransactions()->paginate(50)
        ]);
    }
}
