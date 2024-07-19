<?php

namespace App\Libs\Form\Factory;

use App\Enums\TenantSettingsType;
use App\Libs\Form\Builder\Fields\TextField;
use App\Libs\Form\Builder\Form;

class PaystackSettingsForm extends FormFactory
{

    public static function messages(): array
    {
        return [
            '*.required_with' => ':attribute is required'
        ];
    }

    public static function modifyDataBeforeSave(array $data, array $form)
    {
        $data['paystack.secret'] = encrypt($form['paystack_secret']);
        return $data;
    }

    public static function rules(): array
    {
        if(request()->has('paystack_secret')){
            return [
                'paystack_secret' => ['required']
            ];
        }

        return [];
    }
    public static function make(): Form
    {
        return Form::make()
            ->title('Add Paystack Credentials')
            ->description("If you'd like to enable automatic payments, kindly include your Paystack details. This will allow your customers to conveniently deposit funds into your account with ease")
            ->action(route('settings.update', TenantSettingsType::PAYMENT))
            ->method('post')
            ->addField(TextField::make()
                ->name('paystack_secret')
                ->type('password')
                ->label('Paystack Secret Key')
                ->placeholder('Paystack Secret Key')
                ->value(auth()->user()->config['paystack.secret'] ?? null));
    }
}
