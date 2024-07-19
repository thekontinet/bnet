<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableIfNoSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Organization $tenant */
        $tenant = tenant();

        if($tenant->subscription()->doesntExist() || $tenant->subscription?->isOnGracePeriod()){
            //TODO: Work on this to display a specific view
            abort(503);
        }

        return $next($request);
    }
}
