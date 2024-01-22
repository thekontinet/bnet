<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseTenantController
{
    public function __construct()
    {
        Auth::setDefaultDriver('web');
    }

    public function view(string $name, array $data = [])
    {
        return view("template::$name", $data);
    }
}
