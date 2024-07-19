<?php

namespace App\Enums;

use App\Libs\Form\Factory\BankSettingsForm;
use App\Libs\Form\Factory\CustomerAccountSettingsForm;
use App\Libs\Form\Factory\CustomerPasswordSettingsForm;
use App\Libs\Form\Factory\PaystackSettingsForm;
use App\Libs\Forms\Fields\TextField;
use App\Libs\Forms\Form;

enum CustomerSettingsType: string
{
    case Account = 'account';

    case SECURITY = 'security';

    public function getForms(): array | \App\Libs\Form\Builder\Form
    {
        return match ($this) {
            self::Account => CustomerAccountSettingsForm::make(),
            self::SECURITY => CustomerPasswordSettingsForm::make()
        };
    }

    public function rules(): array
    {
        return match ($this) {
            self::Account => [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:16', 'start_with:+234'],
            ]
        };
    }

    public function messages(): array
    {
        return [];
    }
}
