<?php

namespace App\Services;

use App\Models\Contracts\Customer;
use App\Models\Contracts\Subscriber;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function getSubscriber(?Tenant $tenant)
    {
        return $tenant ?? auth()->user();
    }
    public function hasActiveSubscription(?Tenant $tenant = null)
    {
        $subscriber = $this->getSubscriber($tenant);
        $subscription = $subscriber->subscription;

        if(!$subscription) return false;

        if($subscription->expires_at->isPast()) return false;

        return true;
    }

    public function subscriberCanUpgradeToPlan(Plan $plan, ?Tenant $tenant = null): bool
    {
        $subscriber = $this->getSubscriber($tenant);
        return !($subscriber->subscription?->plan_id === $plan->id);
    }

    public function subscribe(Plan $plan, ?Tenant $tenant = null): Subscription
    {
        //TODO: Add feature to make sure user is not downgrading while plan is still active
        $subscriber = $this->getSubscriber($tenant);
        return DB::transaction(function() use ($subscriber, $plan){
            $subscriber->wallet->withdraw($plan->price->getAmount(), [
                'description' => "Purchase of $plan->title"
            ]);


            $subscriber->subscription()->delete();
            return $subscriber->subscription()->firstOrCreate(
                [],
                ['expires_at' => $plan->getExpiryDate(), 'plan_id' => $plan->id]
            );
        });
    }
}
