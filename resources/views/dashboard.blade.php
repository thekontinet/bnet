<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <a href="{{request()->user()->website_url}}" target="_blank">
                <x-secondary-button class="flex-col">
                    Visit Website
                </x-secondary-button>
            </a>
        </div>
    </x-slot>

    <section class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
        <x-alert.no-subscription-plan/>
    </section>

    <section class="mb-4 max-w-7xl mx-auto sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-4">
        <x-card class="text-gray-900">
            <h4 class="text-xs">Wallet Balance</h4>
            <p class="text-xl">{{money($tenant->wallet->balance)}}</p>
            <a href="{{route('deposit.create')}}" class="mt-4 block">
                <x-primary-button class="flex-col">
                    Fund Wallet
                </x-primary-button>
            </a>
        </x-card>
        <x-card class="p-6 text-gray-900">
            <h4 class="text-xs">Customers</h4>
            <p class="text-xl">{{$customer_count}}</p>
        </x-card>
        <x-card class="p-6 text-gray-900">
            <h4 class="text-xs">Current Plan</h4>
            <p class="text-xl">{{$tenant->activePlan?->title ?? 'No active subscription'}}</p>
            <p class="text-xs">Expiry: {{$tenant->subscription?->expires_at->diffForHumans()}}</p>
        </x-card>
    </section>


    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-card>
            <div class="container px-4 mx-auto">
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">Recent Orders</h2>
                </div>
                @include('orders.partials.orders-table')
            </div>
        </x-card>
    </section>
</x-app-layout>
