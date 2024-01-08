<?php

namespace App\Enums\Settings;

use App\Enums\Settings\Contracts\Settings;

enum AutomaticPaymentSetting: string implements Settings
{
    case PaystackSecret = 'paystack-secret';
    case PaystackPublic = 'paystack-public';

    public static function getFields(): array
    {
        return [
            self::PaystackSecret->value => [
                'label' => 'Paystack Secret',
                'name' => self::PaystackSecret->value
            ],
            self::PaystackPublic->value => [
                'label' => 'Paystack Public',
                'name' => self::PaystackSecret->value
            ],
        ];
    }
}
