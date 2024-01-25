<?php

namespace App\Services;

use App\Libs\WhoIsApi;
use Illuminate\Support\Facades\Cache;

class DomainService
{
    public function __construct(private readonly  WhoIsApi $domainProvider)
    {
    }
    public function checkAvailability(string $domain): bool
    {
        if(!app()->isProduction()) return true;
        return Cache::remember("domain-availability-check" . $domain, now()->addDay(), function() use($domain){
            return $this->domainProvider->domainIsAvailable($domain);
        });
    }
}
