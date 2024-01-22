<?php

namespace App\Enums;

use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\Contracts\PackageManager;
use App\Services\VtuProviders\DataPackageManager;
use App\Services\VtuProviders\FakePackageManager;

enum ServiceEnum: string
{
    case AIRTIME = 'airtime';

    case DATA = 'data';

    public function getLucideIcon()
    {
        return match ($this){
            ServiceEnum::DATA => 'wifi',
            ServiceEnum::AIRTIME => 'tablet-smartphone'
        };
    }

    public function processor(): PackageManager
    {
        if(!app()->isProduction()) return app(FakePackageManager::class);

        return match ($this){
            ServiceEnum::AIRTIME => app(AirtimePackageManager::class),
            ServiceEnum::DATA => app(DataPackageManager::class),
            default => throw new \Exception('Service manager not found')
        };
    }
}
