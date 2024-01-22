<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use Illuminate\Http\Request;

class ProfileController extends BaseTenantController
{

    public function update(Request $request)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        auth()->user()->update($validated);

        return redirect()->back()->with('message', 'Profile updated');
    }
}
