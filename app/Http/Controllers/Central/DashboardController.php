<?php

namespace App\Http\Controllers\Central;

use App\Builders\NotificationBuilder;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Notification;
use App\Services\PackageService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, PackageService $packageService)
    {
        $actions = $this->getTenantActions($request->user());

        return view('dashboard', [
            'actions' => $actions,
            'tenant' => auth()->user(),
            'customer_count' => auth()->user()->customers()->count(),
            'orders' => $request->user()->orders()
                ->with(['customer'])
                ->latest()
                ->limit(20)->get()
        ]);
    }

    public function getTenantActions(Organization $tenant): array
    {
        $hasTransact = $tenant->walletTransactions()->count();
        $hasSubscribedOnce = $tenant->subscription()->exists();
        return [
            [
                'message' => 'Please add payment options for your customers to make payment',
                'name' => 'Click here to add payment option',
                'url' => route('settings.edit', 'payment'),
                'active' => !$tenant->hasPaymentMethod()
            ],
            [
                'message' => 'Your wallet is empty. Fund your wallet to enable data purchase',
                'name' => 'Click here to make your first deposit',
                'url' => route('deposit'),
                'active' => !$hasTransact
            ],
            [
                'message' => 'Please subscribe to activate your platform and start enjoying our service',
                'name' => 'Subscribe',
                'url' => route('subscribe.create'),
                'active' => !$tenant->subscription
            ],
            [
                'message' => 'Your subscription needs renewal. To continue enjoying our services, please renew your subscription',
                'name' => 'Renew subscription',
                'url' => route('subscribe.create'),
                'active' => $tenant->subscription && $tenant->subscription->isOnGracePeriod()
            ]
        ];
    }
}
