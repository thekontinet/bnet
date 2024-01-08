<?php

namespace App\Models\Contracts;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSubscription
{
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

}
