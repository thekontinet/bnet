<?php

namespace App\Enums\Settings;

use App\Enums\Settings\Contracts\Settings;

enum ManualPaymentSetting: string implements Settings
{
    case BankName = 'bank-name';
    case AccountName = 'account-name';
    case AccountNumber = 'account-number';

    public static function getFields(): array
    {
        return [
            self::BankName->value => [
                'label' => 'Bank Name',
                'name' => self::BankName->value
            ],
            self::AccountName->value => [
                'label' => 'Account Name',
                'name' => self::AccountName->value
            ],
            self::AccountNumber->value => [
                'label' => 'Account Number',
                'name' => self::AccountNumber->value
            ]
        ];
    }
}
