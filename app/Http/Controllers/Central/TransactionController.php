<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        return view('transaction.index', [
            'transactions' => $request->user()
                ->walletTransactions()
                ->latest()
                ->paginate()
        ]);
    }
}
