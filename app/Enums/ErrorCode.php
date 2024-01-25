<?php

namespace App\Enums;

enum ErrorCode: string
{
    const DELIVERY_FAILED = 700;

    const ORDER_PROCESSING_FAILED = 600;

    const TRANSACTION_ERROR = 601;

    const TENANT_OUT_OF_BUSINESS = 602; // code for tenent low balance when client is purchasing

    public static function exist($code)
    {
        return collect(self::cases())->pluck('value')->contains($code);
    }

    public static function getMessage(int $code): ?string
    {
        return match ($code){
            self::DELIVERY_FAILED => 'Something went wrong while delivering your package. Please try again later',
            self::TENANT_OUT_OF_BUSINESS => 'Service not available at the moment. Try again later',
            default => null
        };
    }
}
