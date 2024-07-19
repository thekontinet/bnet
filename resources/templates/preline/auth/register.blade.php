<x-tenant::layouts.guest class="p-4">
    <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign up</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
            Have an account with us ?
            <a class="text-primary-600 decoration-2 hover:underline font-medium dark:text-primary-500" href="{{route('tenant.login')}}">
                Sign in here
            </a>
        </p>
    </div>
    <div class="mt-5">
        <section class="w-full py-4 ">
            <form class="w-full mt-4 grid grid-cols-2 gap-2" action="{{route('tenant.register')}}" method="post">
                @csrf

                <!-- Firstname -->
                <div>
                    <x-tenant::input-label for="firstname" :value="__('Firstname')" />
                    <x-tenant::text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                    <x-tenant::input-error :messages="$errors->get('firstname')" class="mt-2" />
                </div>

                <!-- Lastname -->
                <div>
                    <x-tenant::input-label for="lastname" :value="__('Lastname')" />
                    <x-tenant::text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autocomplete="lastname" />
                    <x-tenant::input-error :messages="$errors->get('lastname')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="col-span-full">
                    <x-tenant::input-label for="email" :value="__('Email')" />
                    <x-tenant::text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-tenant::input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div class="col-span-full">
                    <x-tenant::input-label for="tel" :value="__('Whatsapp Number')" />
                    <x-tenant::text-input id="tel" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="phone"/>
                    <x-tenant::input-error :messages="$errors->get('phone')" class="mt-2" />
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

                <!-- Confirm Password -->
                <div class="col-span-full">
                    <x-tenant::input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-tenant::text-input id="password_confirmation" class="block mt-1 w-full"
                                          type="password"
                                          name="password_confirmation" required />

                    <x-tenant::input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{--TODO: Add term and condition feature here--}}


                <x-tenant::primary-button class="w-full col-span-full mt-4">Create Account</x-tenant::primary-button>
            </form>
        </section>
    </div>
</x-tenant::layouts.guest>
