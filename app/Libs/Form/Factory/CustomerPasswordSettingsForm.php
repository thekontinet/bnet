<?php

namespace App\Libs\Form\Factory;

use App\Enums\Config;
use App\Enums\TenantSettingsType;
use App\Libs\Form\Builder\Fields\TextField;
use App\Libs\Form\Builder\Form;

class CustomerPasswordSettingsForm extends FormFactory
{
    public static function make(): Form
    {
        return  Form::make()
            ->action(route('tenant.password.update'))
            ->method('post')
            ->title(__('Security Settings'))
            ->description(__('Update your password'))
            ->addField(TextField::make()
                ->name('current_password')
                ->type('password')
                ->label('Current Password')
                ->placeholder('Current Password'))

            ->addField(TextField::make()
                ->name('password')
                ->type('password')
                ->label('New Password')
                ->placeholder('New Password'))

            ->addField(TextField::make()
                ->name('password_confirmation')
                ->type('password')
                ->label('Confirm New Password')
                ->placeholder('Confirm New Password'));
    }
}
