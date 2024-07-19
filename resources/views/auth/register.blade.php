<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{passwordShow:false}">
        @csrf
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="John Doe" required="" autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="example@email.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            x-bind:type="passwordShow ? 'text' : 'password'"
                            name="password"
                            required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="flex">
            <button class="text-xs mt-2 inline-block ml-auto" type="button" x-on:click="passwordShow = !passwordShow">Show password</button>
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <x-slot name="footer">
        <div class="py-8">
            <x-link href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </x-link>
        </div>
    </x-slot>
</x-guest-layout>
