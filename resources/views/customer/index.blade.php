<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Customers') }}
            </h2>

            <x-link href="{{route('dashboard')}}" target="_blank">
                {{__('Back')}}
            </x-link>
        </div>
    </x-slot>

    <x-container>
        <form>
            <div class="mb-2">
                <x-text-input type="search" name="search" class="w-full" placeholder="Search Email" :value="request()->query('search')"/>
            </div>
            <x-primary-button>Search</x-primary-button>
        </form>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 items-center gap-4 mt-4">
            @forelse($customers as $customer)
                <x-customer.card :customer="$customer"/>
            @empty
                <p class="text-center col-span-full py-4">No Data</p>
            @endforelse

            <div class="mt-4">
                {{$customers->links()}}
            </div>
        </div>
    </x-container>
</x-app-layout>
