<x-tenant::layouts.app>
    <x-tenant::appbar title="Settings"/>

    <section class="pb-32 bg-white rounded-t-xl p-4 min-h-screen">
        <header class="mb-4">
            <h4 class="font-medium">Password Settings</h4>
            <p class="text-sm">Secure your account with a strong password</p>
        </header>

        <form action="{{ route('tenant.password.update') }}" method="post" class="space-y-4">
            @csrf
            <div>
                <x-tenant::input-label for="current-password" value="Current Password"/>
                <x-tenant::text-input type="password" class="w-full" name="current_password" id="current-password" required=""/>
                <x-tenant::input-error :messages="$errors->get('current_password')"/>
            </div>

            <div>
                <x-tenant::input-label for="password" value="Password"/>
                <x-tenant::text-input type="password" class="w-full" name="password" id="password" required=""/>
                <x-tenant::input-error :messages="$errors->get('password')"/>
            </div>

            <div>
                <x-tenant::input-label for="confirm-password" value="Password"/>
                <x-tenant::text-input type="password" class="w-full" name="password_confirmation" id="confirm-password" required=""/>
                <x-tenant::input-error :messages="$errors->get('password_confirmation')"/>
            </div>

            <x-tenant::primary-button>Update</x-tenant::primary-button>
        </form>
    </section>
</x-tenant::layouts.app>
