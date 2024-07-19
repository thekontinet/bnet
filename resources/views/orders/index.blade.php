<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Orders') }}
            </h2>

            <x-link href="{{route('dashboard')}}" target="_blank">
                {{__('Back')}}
            </x-link>
        </div>
    </x-slot>

    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <x-card>
            <div class="container px-4 mx-auto">
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">Order History</h2>
                </div>
                @include('orders.partials.orders-table')
            </div>

            <div class="mt-4 px-4">
                {{$orders->links()}}
            </div>
        </x-card>
    </section>
</x-app-layout>
