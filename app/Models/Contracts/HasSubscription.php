<?php

namespace App\Models\Contracts;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

trait HasSubscription
{
    public function getPlan()
    {
        return $this->subscription?->plan;
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

}
