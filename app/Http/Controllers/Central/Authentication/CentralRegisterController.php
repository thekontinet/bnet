<?php

namespace App\Http\Controllers\Central\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class CentralRegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'alpha_num', 'max:255', 'unique:'.Tenant::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Tenant::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $tenant = Tenant::query()->create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $tenant->createDomain($tenant->username . '.' . $request->getHost());

        event(new Registered($tenant));

        Auth::login($tenant);

        return redirect(RouteServiceProvider::HOME);
    }
}
