<x-tenant::layouts.guest class="flex flex-col gap-8 items-center justify-center p-4">
    <section class="w-full shadow py-12 px-8">
        <header>
            <div class="mb-2 size-24 border border-slate-700 flex items-center justify-center rounded-full overflow-hidden">
                <x-tenant::application-logo/>
            </div>
            <h4 class="text-lg font-medium">Login</h4>
            <p class="text-sm text-slate-400">Enter your credentials to login, or create a new account if you're new here</p>
        </header>
        <form class="w-full mt-4" action="{{route('tenant.login')}}" method="post">
            @csrf

            <!-- Email Address -->
            <div class="mt-4">
                <x-tenant::input-label for="email" :value="__('Email')" />
                <x-tenant::text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-tenant::input-label for="password" :value="__('Password')" />

                <x-tenant::text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-tenant::input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4 flex flex-col items-start gap-2">
                <x-tenant::primary-button>Login</x-tenant::primary-button>
            </div>
        </form>
    </section>
    <a href="{{route('tenant.register')}}" class="text-slate-500">I want to create a new acoount ?</a>
</x-tenant::layouts.guest>
