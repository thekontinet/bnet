<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card class="p-6 text-gray-900">
                    @if($packages)
                        @include('service.partials.price-update-form')
                    @elseif($providers)
                        @include('service.partials.providers-list')
                    @else
                        @include('service.partials.services-list')
                    @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
