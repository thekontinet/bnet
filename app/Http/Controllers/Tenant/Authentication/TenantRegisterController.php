<?php

namespace App\Http\Controllers\Tenant\Authentication;

use App\Http\Controllers\BaseTenantController;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class TenantRegisterController extends BaseTenantController
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return $this->view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:14', Rule::unique(Customer::class)->where('tenant_id', tenant('id'))],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Customer::class)->where('tenant_id', tenant('id'))],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::query()->create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($customer));

        Auth::guard('web')->login($customer);

        return redirect(RouteServiceProvider::HOME);
    }
}
