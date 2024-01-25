<x-guest-layout>
    <h2 class="font-medium text-lg">Register a New Domain</h2>
    <p class="text-sm text-gray-400 mb-4">Create a new <strong>.com.ng</strong> domain name for your business</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('domain.store') }}">
        @csrf

        <!-- Domain Name -->
        <div>
            <x-input-label for="domain" :value="__('Domain')" />
            <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->domainCreated->get('domain')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Proceed') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
