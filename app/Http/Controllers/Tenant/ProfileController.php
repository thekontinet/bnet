<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;
use Illuminate\Http\Request;

class ProfileController extends BaseTenantController
{

    public function update(Request $request)
    {
        $validated = $request->validateWithBag('profile', [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user()->fill($validated);

        if($user->isDirty('email')){
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->back()->with('message', 'Profile updated');
    }
}
