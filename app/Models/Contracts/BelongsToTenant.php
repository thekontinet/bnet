<?php

declare(strict_types=1);

namespace App\Models\Contracts;

use App\Models\Scopes\TenantScope;
use Stancl\Tenancy\Contracts\Tenant;

/**
 * @property-read Tenant $tenant
 */
trait BelongsToTenant
{
    public static $tenantIdColumn = 'organization_id';

    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (! $model->getAttribute(self::$tenantIdColumn) && ! $model->relationLoaded('tenant')) {
                if (tenancy()->initialized) {
                    $model->setAttribute(self::$tenantIdColumn, tenant()->getTenantKey());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(config('tenancy.tenant_model'), self::$tenantIdColumn);
    }
}
