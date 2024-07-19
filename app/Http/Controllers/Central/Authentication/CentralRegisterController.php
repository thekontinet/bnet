<?php

namespace App\Http\Controllers\Central\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CentralRegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Organization::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $tenant = Organization::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($tenant));

        Auth::login($tenant);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }
}
