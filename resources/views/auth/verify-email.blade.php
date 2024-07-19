<x-guest-layout>
    <div class="mb-4 text-sm">
        <p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            <p>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</p>
        </div>
    @endif

    <div class="flex gap-4 items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-link>
                    {{ __('Resend') }}
                </x-link>
            </div>
        </form>

        OR

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-link type="submit">
                {{ __('Log Out') }}
            </x-link>
        </form>
    </div>
</x-guest-layout>
