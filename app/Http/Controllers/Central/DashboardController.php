<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard', [
            'tenant' => auth()->user(),
            'customer_count' => auth()->user()->customers()->count(),
            'plan_remaining_days' => auth()->user()->subscription?->expires_at->diffForHumans(),
            'orders' => $request->user()->orders()
                ->with(['owner'])->latest()->limit(20)->get()
        ]);
    }
}
