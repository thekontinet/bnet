<?php

namespace App\Libs\Form\Factory;

use App\Enums\Config;
use App\Enums\TenantSettingsType;
use App\Libs\Form\Builder\Fields\TextField;
use App\Libs\Form\Builder\Form;

class CustomerAccountSettingsForm extends FormFactory
{
    public static function make(): Form
    {
        return  Form::make()
            ->action(route('tenant.profile.update'))
            ->method('post')
            ->title(__('Account Settings'))
            ->description(__('Update account informtion'))
            ->addField(TextField::make()
                ->name('firstname')
                ->type('text')
                ->label('First Name')
                ->placeholder('First Name')
                ->value(auth()->user()->firstname ?? ''))

            ->addField(TextField::make()
                ->name('lastname')
                ->type('text')
                ->label('Lastname')
                ->placeholder('Lastname')
                ->value(auth()->user()->lastname ?? ''))

            ->addField(TextField::make()
                ->name('email')
                ->type('text')
                ->label('Email')
                ->placeholder('Email')
                ->value(auth()->user()->email ?? ''))

            ->addField(TextField::make()
                ->name('phone')
                ->type('text')
                ->label('Phone')
                ->placeholder('Phone')
                ->value(auth()->user()->phone ?? ''));
    }
}
