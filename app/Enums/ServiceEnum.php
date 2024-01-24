<?php

namespace App\Enums;

use App\Models\Package;
use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\Contracts\PackageManager;
use App\Services\VtuProviders\DataPackageManager;
use App\Services\VtuProviders\FakePackageManager;

enum ServiceEnum: string
{
    case AIRTIME = 'airtime';

    case DATA = 'data';

    public function pricingType(): string
    {
        return match ($this){
          self::AIRTIME => Package::PRICE_TYPE_DISCOUNT,
          self::DATA => Package::PRICE_TYPE_FIXED,
        };
    }

    public function pricingTypeIsFixed(): bool
    {
        return $this->pricingType() === Package::PRICE_TYPE_FIXED;
    }

    public function getLucideIcon()
    {
        return match ($this){
            ServiceEnum::DATA => 'wifi',
            ServiceEnum::AIRTIME => 'tablet-smartphone'
        };
    }

    public function getPackageManger(): PackageManager
    {
        // TODO: Instead of doing this, add on and off for these services
        if(!app()->isProduction()) return app(FakePackageManager::class);

        return match ($this){
            ServiceEnum::AIRTIME => app(AirtimePackageManager::class),
            ServiceEnum::DATA => app(DataPackageManager::class),
        };
    }
}
