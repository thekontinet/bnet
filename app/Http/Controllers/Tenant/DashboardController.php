<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends BaseTenantController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->view('dashboard', [
            'user' => auth()->user(),
            'transactions' => auth()->user()->walletTransactions()
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(5)->get(),
        ]);
    }
}
