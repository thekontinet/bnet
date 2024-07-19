<x-tenant::layouts.guest class="p-4">
    <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
            Don't have an account yet ?
            <a class="text-primary-600 decoration-2 hover:underline font-medium dark:text-primary-500" href="{{route('tenant.register')}}">
                Sign up here
            </a>
        </p>
    </div>
    <div class="mt-2">
        <section class="w-full py-4 ">
            <form class="w-full mt-4 grid grid-cols-2 gap-2" action="{{route('tenant.login')}}" method="post">
                @csrf

                <!-- Email Address -->
                <div class="col-span-full">
                    <x-tenant::input-label for="email" :value="__('Email')" />
                    <x-tenant::text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="col-span-full">
                    <x-tenant::input-label for="password" :value="__('Password')" />

                    <x-tenant::text-input id="password" class="block mt-1 w-full"
                                          type="password"
                                          name="password"
                                          required />

                    <x-tenant::input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Checkbox -->
                <div class="flex items-center">
                    <div class="flex">
                        <input id="remember-me" name="remember" type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-primary-600 focus:ring-primary-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-primary-500 dark:checked:border-primary-500 dark:focus:ring-offset-gray-800">
                    </div>
                    <div class="ms-3">
                        <label for="remember-me" class="text-sm dark:text-white">Remember me</label>
                    </div>
                </div>
                <!-- End Checkbox -->


                <x-tenant::primary-button class="w-full col-span-full mt-4">Login</x-tenant::primary-button>
            </form>
        </section>
    </div>
</x-tenant::layouts.guest>
