<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PAID = 'paid';
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case DELIVERED = 'delivered';
    case DELIVERING = 'delivering';
    case FAILED = 'failed';

    case PARTIALLY_DELIVERED = 'partially_delivered';

    case REFUNDED = 'refunded';

    public function getTextColor(): string
    {
        return match ($this){
            self::PENDING => 'text-amber-500',
            self::SUCCESS => 'text-green-500',
            self::FAILED, self::REFUNDED => 'text-red-500',
            self::PAID => 'text-orange-500',
            self::DELIVERING => 'text-amber-600',
            self::PARTIALLY_DELIVERED => 'text-orange-600',
            self::DELIVERED => 'text-green-600'
        };
    }

    public function getBgColor(): string
    {
        return match ($this){
            self::PENDING => 'bg-amber-300/60',
            self::SUCCESS => 'bg-green-300/60',
            self::FAILED, self::REFUNDED => 'bg-red-300/60',
            self::PAID => 'bg-orange-300/60',
            self::DELIVERING => 'bg-amber-400/60',
            self::PARTIALLY_DELIVERED => 'bg-orange-400/60',
            self::DELIVERED => 'bg-green-400/60'
        };
    }
}
