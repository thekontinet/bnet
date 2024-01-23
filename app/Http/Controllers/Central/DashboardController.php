<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Services\PackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, PackageService $packageService)
    {
        /**
         * TODO: move this to a schedule worker or to dashboard controller
         */
        if(Cache::lock('user' . auth()->id() . 'service-lock', 1800, auth()->id())){
            $packageService->syncTenantPackages(auth()->user());
        }

        return view('dashboard', [
            'tenant' => auth()->user(),
            'customer_count' => auth()->user()->customers()->count(),
            'orders' => $request->user()->orders()
                ->with(['owner'])->latest()->limit(20)->get()
        ]);
    }
}
