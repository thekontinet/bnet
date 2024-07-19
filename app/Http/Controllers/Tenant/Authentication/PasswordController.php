<?php

namespace App\Http\Controllers\Tenant\Authentication;

use App\Http\Controllers\BaseTenantController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends BaseTenantController
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if($request->current_password === $request->password){
            return back()->with('message', 'Password updated');
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('message', 'Password updated');
    }
}
