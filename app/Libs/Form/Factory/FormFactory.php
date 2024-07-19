<?php

namespace App\Libs\Form\Factory;

use App\Libs\Form\Builder\Form;

abstract class FormFactory
{
    public static function rules(): array
    {
        return [];
    }

    public static function messages(): array
    {
        return [];
    }
    abstract public static function make(): Form;
}
