<x-tenant::layouts.guest>
    <section class="flex flex-col items-center justify-center min-h-screen w-full">
        <div class="max-w-[100px] w-full mx-auto">
            <x-tenant::application-logo/>
        </div>
        <h4 class="text-lg font-medium mb-4">Login</h4>
        <form class="w-full px-8 py-12" action="{{route('tenant.login')}}" method="post">
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
                <a href="{{route('tenant.register')}}" class="underline">Dont have an account ?</a>
            </div>
        </form>
    </section>
</x-tenant::layouts.guest>
