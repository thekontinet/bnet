<?php

namespace App\Http\Middleware;

use App\Enums\Config;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustCompleteRequiredSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$this->completeApplicationSettings($request)) return redirect()->route('site')
            ->with('message', 'Complete your website information');

        if(!$this->haveAtleastOnePaymentMethod($request))
            return redirect()->route('settings.edit', 'payment')
                ->with('message', 'Choose and complete at least one payment form.');
        return $next($request);
    }

    public function completeApplicationSettings(Request $request): bool
    {
        $user = $request->user();
        return $user->brand_name && $user->brand_description && $user->logo;
    }

    public function haveAtleastOnePaymentMethod(Request $request): bool
    {
        $user = $request->user();
        return $user->settings()->get(Config::PAYSTACK_SECRET->value) ||
            ($user->settings()->get(Config::BANK_ACCOUNT_NUMBER->value) &&
                $user->settings()->get(Config::BANK_ACCOUNT_NAME->value) &&
                $user->settings()->get(Config::BANK_NAME->value));
    }
}
