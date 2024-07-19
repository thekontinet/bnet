<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use Illuminate\Http\Request;

class DashboardController extends BaseTenantController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('template::dashboard', [
            'user' => auth()->user(),
            'transactions' => auth()->user()->walletTransactions()
                ->latest()
                ->limit(5)->get(),
            'orders' => $request->user()->orders()->latest()->limit(6)->get()
        ]);
    }
}
