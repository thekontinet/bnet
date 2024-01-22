<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>
    <x-container>
        <x-card>
            <header>
                <form>
                    <div class="mb-2">
                        <x-input-label for="search" value="Search"/>
                        <x-text-input type="search" name="search" class="w-full" placeholder="Search Email" :value="request()->query('search')"/>
                    </div>
                    <x-primary-button>Search</x-primary-button>
                </form>
            </header>
        </x-card>

        <hr class="my-2">

        <x-card class="grid md:grid-cols-2 lg:grid-cols-3 items-center gap-4">
            @forelse($customers as $customer)
                <x-customer.card :customer="$customer"/>
            @empty
                <p class="text-center col-span-full py-4">No Data</p>
            @endforelse

            <div class="mt-4">
                {{$customers->links()}}
            </div>
        </x-card>
    </x-container>
</x-app-layout>
