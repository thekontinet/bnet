<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;

class TransactionController extends BaseTenantController
{
    public function index()
    {
        return $this->view('transaction.index',[
            'transactions' => auth()->user()->walletTransactions()->paginate(50)
        ]);
    }
}
