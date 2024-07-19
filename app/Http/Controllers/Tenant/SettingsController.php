<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use Illuminate\Http\Request;

class SettingsController extends BaseTenantController
{
    public function __invoke(Request $request)
    {
        return view('template::setting.index',[
            'user' => $request->user(),
            'socials' => config('tenant.app.social')
        ]);
    }
}
