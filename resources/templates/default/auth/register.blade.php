<x-tenant::layouts.guest class="flex flex-col gap-8 items-center justify-center p-4">
    <section class="w-full shadow py-12 px-8">
        <header>
            <div class="mb-2 size-24 border border-slate-700 flex items-center justify-center rounded-full overflow-hidden">
                <x-tenant::application-logo/>
            </div>
            <h4 class="text-lg font-medium">Create a New Account</h4>
            <p class="text-sm text-slate-400">Complete the form to create a new account</p>
        </header>
        <form class="w-full mt-4" action="{{route('tenant.register')}}" method="post">
            @csrf

            <!-- Firstname -->
            <div>
                <x-tenant::input-label for="firstname" :value="__('Firstname')" />
                <x-tenant::text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                <x-tenant::input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div class="mt-4">
                <x-tenant::input-label for="lastname" :value="__('Lastname')" />
                <x-tenant::text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                <x-tenant::input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-tenant::input-label for="email" :value="__('Email')" />
                <x-tenant::text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-tenant::input-label for="tel" :value="__('Phone')" />
                <x-tenant::text-input id="tel" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="phone" />
                <x-tenant::input-error :messages="$errors->get('phone')" class="mt-2" />
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

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-tenant::input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-tenant::text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />

                <x-tenant::input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4 flex flex-col items-start gap-2">
                <x-tenant::primary-button>Create Account</x-tenant::primary-button>
            </div>
        </form>
    </section>
    <a href="{{route('tenant.login')}}" class="text-slate-500">Take me to login</a>
</x-tenant::layouts.guest>
