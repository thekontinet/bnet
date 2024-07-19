<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <a href="{{request()->user()->website_url}}" target="_blank">
                <x-secondary-button class="flex-col">
                    Visit Website
                </x-secondary-button>
            </a>
        </div>
    </x-slot>

    <section class="max-w-7xl py-2 mx-auto sm:px-6 lg:px-8">
        <x-alert.no-subscription-plan :actions="$actions"/>
    </section>

    <section class="mb-4 max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 lg:grid-cols-2 gap-4">

        <x-preline.stat
            class="col-span-full"
            icon="bi-wallet"
            title="Wallet Balance"
            content="{{money($tenant->wallet->balance)}}"
            href="{{route('deposit')}}"
            label="Fund Balance"/>

        <x-preline.stat
            icon="bi-people"
            title="Customers"
            content="{{$customer_count}}"
            href="{{route('customer.index')}}"
            label="My Customers"/>

        <x-preline.stat
            icon="bi-award"
            title="Plan"
            label="{{$tenant->subscription?->expiring() ? 'Renew' : 'Upgrade'}}"
            href="{{route('subscribe.create')}}"
            content="{{$tenant->subscription?->plan?->title ?? 'No active subscription'}}"/>
    </section>


    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-card>
            <header>
                <h2 class="text-lg font-medium dark:text-white">Recent Orders</h2>
            </header>
            <div>
                @include('orders.partials.orders-table')
            </div>
        </x-card>
    </section>
</x-app-layout>
