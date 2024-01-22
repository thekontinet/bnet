<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <a href="{{route('deposit.create')}}">
                <x-primary-button class="flex-col">
                    Fund Wallet
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <section class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-4">
        <x-card class="text-gray-900">
            <h4 class="text-xs">Wallet Balance</h4>
            <p class="text-xl">{{money($tenant->wallet->balance)}}</p>
        </x-card>
        <x-card class="p-6 text-gray-900">
            <h4 class="text-xs">Customers</h4>
            <p class="text-xl">{{$customer_count}}</p>
        </x-card>
        <x-card class="p-6 text-gray-900">
            <h4 class="text-xs">Current Plan</h4>
            <p class="text-xl">{{$tenant->getPlan()?->title}}</p>
            <p class="text-xs">Expiry: {{$plan_remaining_days}}</p>
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
