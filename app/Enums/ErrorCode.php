<?php

namespace App\Enums;

enum ErrorCode: int
{
    const DELIVERY_FAILED = 700;

    const ORDER_PROCESSING_FAILED = 600;

    const LOW_BALANCE = 601;

    const TENANT_OUT_OF_BUSINESS = 602; // code for tenent low balance when client is purchasing

    public static function getMessage(int $code): ?string
    {
        return match ($code){
            self::DELIVERY_FAILED => 'Something went wrong while delivering your package. Please try again later',
            self::TENANT_OUT_OF_BUSINESS => 'Service not available at the moment. Try again later',
            default => null
        };
    }
}
