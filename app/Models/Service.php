<?php

namespace App\Models;

use App\DataObjects\AirtimePackageData;
use App\DataObjects\DataPlanPackageData;
use App\Enums\ServiceEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Stancl\Tenancy\Contracts\Tenant;

/**
 * @method static Builder central(ServiceEnum $service)
 * @method static Builder tenant(Tenant $tenant, ServiceEnum $service)
 */
class Service extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'collection',
    ];

    public static function upsertServiceData(ServiceEnum $serviceEnum, $data, Organization|null $organization = null, Service|null $parent = null): static
    {
        return Service::query()->updateOrCreate([
            'name' => $serviceEnum->value,
            'organization_id' => $organization?->getKey() ?? null,
            'parent_id' => $parent?->getKey() ?? null,
        ],[
            'data' => $data
        ]);
    }

    public function scopeCentral(Builder $builder, ServiceEnum $service): Builder
    {
        return $builder->where([
            'name' => $service->value,
            'organization_id' => null,
            'parent_id' => null
        ]);
    }

    public function scopeTenant(Builder $builder, Organization $tenant, ServiceEnum $service): Builder
    {
        return $builder->where([
                    'name' => $service->value,
                    'organization_id' => $tenant->id,
                ])->whereNotNull('parent_id');
    }

    public function getPackages(): Collection
    {
        return match ($this->name){
            ServiceEnum::AIRTIME->value => $this->data->map(fn($data) => AirtimePackageData::fromArray($data)),
            ServiceEnum::DATA->value => $this->data->map(fn($data) => DataPlanPackageData::fromArray($data)),
            default => $this->data
        };
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }
}
