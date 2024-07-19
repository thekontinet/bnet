<?php

namespace App\Models;

use App\Enums\ServiceEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ServiceEnum $service
 */
class Package extends Model
{
    use HasFactory;

    const PRICE_TYPE_FIXED = '2';

    const PRICE_TYPE_DISCOUNT = '1';

    protected $guarded = [];

    protected $casts = [
        'service' => ServiceEnum::class,
        'price_type' => 'string',
        'data' => 'json',
        'active' => 'boolean'
    ];

    public function code(): Attribute
    {
        return new Attribute(
            fn() => $this->data['package_code'] ?? null
        );
    }

    public function label(): Attribute
    {
        return new Attribute(
            fn() => $this->price_type === Package::PRICE_TYPE_DISCOUNT ?
                "$this->title = $this->discount% discount":
                "$this->title = " . money($this->price)
        );
    }

    public function canBePurchased(): bool
    {
        return $this->active && $this->getPivot();
    }

    public function getPivot()
    {
        return $this->tenants()
            ->where('organization_id', tenant('id'))->first()?->pivot;
    }

    public function tenants()
    {
        return $this->belongsToMany(Organization::class, 'organization_package')
            ->withPivot(['price', 'discount']);
    }

    public function isFixedPriceType(): bool
    {
        return $this->price_type == self::PRICE_TYPE_FIXED;
    }

    public function getMeta(): array
    {
        return [
            'description' => $this->title . ' Purchase'
        ];
    }
}
