<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <a href="{{route('deposit.create')}}">
                <x-primary-button class="flex-col">
                    <span>{{money(auth()->user()->wallet->balance)}}</span>
                    Fund Wallet
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card class="p-6 text-gray-900">
                {{ __("You're logged in!") }}
            </x-card>
        </div>
    </div>
</x-app-layout>
