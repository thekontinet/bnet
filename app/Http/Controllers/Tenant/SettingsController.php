<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends BaseTenantController
{
    public function index()
    {
        return $this->view('setting.index');
    }

    public function edit(string $settings)
    {
        $view = match($settings){
            'account' => 'profile.edit',
            'security' => 'profile.password-update',
            'help' => 'support',
            default => null
        };

        abort_if(!$view, 404);

        return $this->view($view, [
            'user' => auth()->user()
        ]);
    }
}
