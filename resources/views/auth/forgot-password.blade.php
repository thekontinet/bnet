<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __("No worries if you've forgotten your password! Simply provide us with your email address, and we'll send you a link to reset your password. Once you click on the link, you'll be able to select a new password. Easy as that!") }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
    <x-slot name="footer">
        <div class="py-12">
            @if (Route::has('login'))
                <x-link href="{{ route('login') }}">
                    {{ __('Back to login') }}
                </x-link>
            @endif
        </div>
    </x-slot>
</x-guest-layout>
