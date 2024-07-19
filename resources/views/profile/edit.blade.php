<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Account Settings') }}
            </h2>

            <x-link href="{{route('dashboard')}}" target="_blank">
                Back
            </x-link>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </x-card>

            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </x-card>

            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
