<?php

namespace App\Libs;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WhoIsApi
{
    public function checkDomainAvailability(string $domain)
    {
        $apiKey = config('services.whois_api_key');
        $response = Http::get("https://domain-availability.whoisxmlapi.com/api/v1?apiKey={$apiKey}&domainName={$domain}&credits=DA");
        return $response->json();
    }

    public function domainIsAvailable(string $domain): bool
    {
        return $this->checkDomainAvailability($domain)['DomainInfo']['domainAvailability'] === 'AVAILABLE';
    }
}
