<?php

namespace App\Libs\Form\Factory;

use App\Enums\TenantSettingsType;
use App\Libs\Form\Builder\Fields\TextField;
use App\Libs\Form\Builder\Form;

class BankSettingsForm extends FormFactory
{
    public static function messages(): array
    {
        return [
            '*.required_with' => ':attribute is required'
        ];
    }

    public static function rules(): array
    {
        if(request()->has('bank_name')){
            return [
                'bank_name' => ['required', 'string', 'max:255'],
                'account_name' => ['required', 'string', 'max:255'],
                'account_number' => ['required', 'string', 'max:255'],
                'instruction' => ['required', 'string', 'max:500'],
            ];
        }

        return [];
    }

    public static function make(): Form
    {
        return  Form::make()
            ->title('Add Bank Account')
            ->description('Please provide the information about your bank account so that your customers can use it to pay you')
            ->action(route('settings.update', TenantSettingsType::PAYMENT))
            ->method('post')
            ->addField(TextField::make()
                ->name('bank_name')
                ->type('text')
                ->label('Bank Name')
                ->placeholder('Bank Name')
                ->value(auth()->user()->config['bank.name'] ?? null))
            ->addField(TextField::make()
                ->name('account_name')
                ->type('text')
                ->label('Account Name')
                ->placeholder('Account Name')
                ->value(auth()->user()->config['bank.account_name'] ?? null))
            ->addField(TextField::make()
                ->name('account_number')
                ->type('text')
                ->label('Account Number')
                ->placeholder('Account Number')
                ->value(auth()->user()->config['bank.account_number'] ?? null))
            ->addField(TextField::make()
                ->name('instruction')
                ->type('text')
                ->label('Payment Instruction')
                ->placeholder('Add payment instruction')
                ->value(auth()->user()->config['bank.info'] ?? null));
    }

    public static function modifyDataBeforeSave(array $data, array $form)
    {
        $data['bank.info'] = $form['instruction'];
        $data['bank.name'] = $form['bank_name'];
        $data['bank.account_name'] = $form['account_name'];
        $data['bank.account_number'] = $form['account_number'];
        return $data;
    }
}
