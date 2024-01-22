<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';

    public function getTextColor(): string
    {
        return match ($this){
            self::PENDING => 'text-amber-500',
            self::SUCCESS, self::DELIVERED => 'text-green-500',
            self::FAILED => 'text-red-500'
        };
    }

    public function getBgColor(): string
    {
        return match ($this){
            self::PENDING => 'bg-amber-300/60',
            self::SUCCESS, self::DELIVERED => 'bg-green-300/60',
            self::FAILED => 'bg-red-300/60'
        };
    }
}
