<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Config;
use Stancl\Tenancy\Events\TenancyInitialized;

class UploadTenantConfig
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenancyInitialized $event): void
    {
        foreach ($event->tenancy->tenant->config as $key => $value){
            if(in_array($key, $this->hidden())){
                $value = decrypt($value);
            }
            Config::set([
                'tenant.app.' . $key => $value
            ]);
        }
    }

    public function hidden(): array
    {
        return ['paystack.secret'];
    }
}
