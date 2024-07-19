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
        return new Attribute(fn() => $this->subscription()->first()?->plan);
    }

    public function activePlan(): Attribute
    {
        return new Attribute(function (){
            if(!$this->subscription) return null;
            return $this->subscription->hasExpired() ? null : $this->subscription->plan;
        });
    }

    public function subscriptionHasExpired(): bool
    {
        return $this->subscription?->expires_at?->isPast() ?? true;
    }

    public function subscriptionWillSoonExpire(): bool
    {
        // Make the threshold updatable from tha admin panel
        $expirationThreshold = now()->addDays(Subscription::EXPIRY_THRESHOLD);
        return $this?->subscription?->expires_at->isBefore($expirationThreshold) ?? true;
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

}
