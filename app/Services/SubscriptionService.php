<?php

namespace App\Services;

use App\Exceptions\AppError;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\Subscription;

class
SubscriptionService
{
    /**
     * @throws AppError
     */
    public function subscribe(Plan $plan, Organization $tenant): Subscription
    {
        if($tenant->subscription()->exists()){
            return $this->upgrade($tenant, $plan);
        }

        return $plan->subscriptions()->create([
            'organization_id' => $tenant->getKey(),
            'start_at' => now(),
            'expires_at' => now()->add($plan->duration, $plan->interval)
        ]);
    }

    /**
     * @throws AppError
     */
    public function upgrade(Organization $tenant, Plan $plan): Subscription
    {
        if(!$tenant->subscription()->exists()) throw new AppError(
            'You do not have any existing subscription'
        );

        if($plan->level < $tenant->subscription->plan->level){
            $this->downgrade($tenant, $plan);
        }

        if((int) $tenant->subscription->plan_id === (int) $plan->id){
            return $this->renew($tenant, $plan);
        }

        $tenant->subscription()->update([
            'plan_id' => $plan->id,
            'start_at' => $tenant->subscription->expires_at,
            'expires_at' => $tenant->subscription->expires_at->add($plan->duration, $plan->interval)
        ]);

        return $tenant->subscription;
    }

    /**
     * @throws AppError
     */
    public function downgrade(Organization $tenant, Plan $plan): Subscription
    {
        if(!$tenant->subscription()->exists()) throw new AppError(
            'You do not have any existing subscription'
        );

        if(!$tenant->subscription->isOnGracePeriod()){
            throw new AppError(
                'You can only downgrade when your current subscription expires'
            );
        }

        $tenant->subscription()->update([
            'plan_id' => $plan->id,
            'start_at' => now(),
            'expires_at' => now()->add($plan->duration, $plan->interval)
        ]);

        return $tenant->subscription;
    }

    /**
     * @throws AppError
     */
    public function renew(Organization $tenant, Plan $plan): Subscription
    {
        if(!$tenant->subscription()->exists()) throw new AppError(
            'You do not have any existing subscription'
        );

        if((int) $tenant->subscription->plan_id !== (int) $plan->id){
            throw new AppError(
                'You are not subscribed to this plan'
            );
        }

        if(!$tenant->subscription->expiring()){
            throw new AppError(
                'Your current subscription is still active'
            );
        }

        $tenant->subscription()->update([
            'expires_at' => now()->add($plan->duration, $plan->interval)
        ]);

        return $tenant->subscription;
    }
}
