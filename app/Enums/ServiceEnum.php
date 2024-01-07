<?php

namespace App\Enums;

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
}
