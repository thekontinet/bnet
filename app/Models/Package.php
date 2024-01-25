<?php

namespace App\Models;

use App\Enums\ServiceEnum;
use App\Models\Contracts\Customer;
use App\Models\Contracts\Product;
use App\Models\Customer as CustomerModel;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ServiceEnum $service
 */
class Package extends Model implements Product
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

    public function canBePurchased()
    {
        return $this->active;
    }

    public function isFixedPriceType(): bool
    {
        return $this->price_type == self::PRICE_TYPE_FIXED;
    }

    public function getSellerPrice()
    {
        return $this->tenants()
            ->where('tenant_id', tenant('id'))->first()?->pivot;
    }

    public function sellPrice()
    {
        if($this->price_type === self::PRICE_TYPE_FIXED){
            return $this->getSellerPrice()->price;
        }

        if($this->price_type === self::PRICE_TYPE_DISCOUNT){
            if(!request()->get('amount')) throw new InvalidArgumentException('No amount in request');
            return (request()->get('amount') - (request()->get('amount') * ($this->getSellerPrice()->discount/100))) * 100;
        }

        throw new InvalidArgumentException('Invalid package price type');
    }

    public function buyPrice()
    {
        if($this->price_type === self::PRICE_TYPE_FIXED){
            return $this->price;
        }

        if($this->price_type === self::PRICE_TYPE_DISCOUNT){
            if(!request()->get('amount')) throw new InvalidArgumentException('No amount in request');
            return (request()->get('amount') - (request()->get('amount') * ($this->discount/100))) * 100;
        }

        throw new InvalidArgumentException('Invalid package price type');
    }

    public function getPrice(Customer $customer): string
    {
        return match ($customer::class){
            Tenant::class => $this->buyPrice(),
            CustomerModel::class => $this->sellPrice(),
            default => ''
        };
    }

    public function getMeta(): array
    {
        return [
            'description' => $this->title . ' Purchase'
        ];
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'tenant_package')
            ->withPivot(['price', 'discount']);
    }
}
