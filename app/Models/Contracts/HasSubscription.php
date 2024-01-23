<?php

namespace App\Models\Contracts;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

trait HasSubscription
{
    public function plan(): Attribute
    {
        return new Attribute(fn() => $this->subscription?->plan);
    }

    public function activePlan(): Attribute
    {
        return new Attribute(fn() => $this->subscription?->hasExpired() ? null : $this->subscription?->plan);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

}
