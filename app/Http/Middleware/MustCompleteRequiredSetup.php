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
        if(!$request->user()->completeApplicationSettings()) return redirect()->route('site')
            ->with('message', 'Complete your website information');

        if(!$request->user()->haveAtleastOnePaymentMethod())
            return redirect()->route('settings.edit', 'payment')
                ->with('message', 'Choose and complete at least one payment form.');
        return $next($request);
    }
}
