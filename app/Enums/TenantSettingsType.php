<?php

namespace App\Enums;

use App\Libs\Form\Factory\BankSettingsForm;
use App\Libs\Form\Factory\PaystackSettingsForm;
use App\Libs\Forms\Fields\TextField;
use App\Libs\Forms\Form;

enum TenantSettingsType: string
{
    case PAYMENT = 'payment';

    public static function all(): array
    {
        return collect(TenantSettingsType::cases())->pluck('value')->toArray();
    }

    public function getForms(): array
    {
        return match ($this) {
            self::PAYMENT => [
                BankSettingsForm::make(),
                PaystackSettingsForm::make()
            ]
        };
    }

    public function rules(): array
    {
        return match ($this) {
            self::PAYMENT => [
                ...BankSettingsForm::rules(),
                ...PaystackSettingsForm::rules(),
            ]
        };
    }

    public function messages(): array
    {
        return match ($this) {
            self::PAYMENT => [
                ...BankSettingsForm::messages(),
                ...PaystackSettingsForm::messages(),
            ]
        };
    }

    public function modeifyDataBeforeSave(array $data, array $form)
    {
        if($form['bank_name'] ?? false){
            return BankSettingsForm::modifyDataBeforeSave($data, $form);
        }

        if($form['paystack_secret'] ?? false){
            return PaystackSettingsForm::modifyDataBeforeSave($data, $form);
        }

        return [];
    }
}
