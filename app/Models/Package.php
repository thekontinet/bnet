<?php

namespace App\Models;

use App\Enums\ServiceEnum;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    const PRICE_TYPE_FIXED = '2';

    const PRICE_TYPE_DISCOUNT = '1';

    protected $guarded = [];

    protected $casts = [
        'service' => ServiceEnum::class,
        'price_type' => 'string'
    ];

    public function sellPrice()
    {
        if($this->price_type === self::PRICE_TYPE_FIXED){
            return $this->price;
        }

        if($this->price_type === self::PRICE_TYPE_DISCOUNT){
            if(!request()->get('amount')) throw new InvalidArgumentException('No amount in request');
            return request()->get('amount') * ($this->discount/100);
        }

        throw new InvalidArgumentException('Invalid package price type');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'tenant_package')
            ->withPivot(['price', 'discount']);
    }
}
