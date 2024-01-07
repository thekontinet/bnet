<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card class="p-6 text-gray-900">
                <header class="mb-4">
                    <h1 class="font-medium text-lg">Manage {{str($service->value)->ucfirst()}} Service</h1>

                    <div class="flex items-center gap-4 mt-4">
                        @foreach($providers as $provider)
                            <a href="?provider={{$provider}}" class="text-sm bg-slate-200 px-4 py-1 rounded {{request()->get('provider') == $provider ? 'bg-black text-white' : 'hover:bg-gray-500 hover:text-white'}}">{{$provider}}</a>
                        @endforeach
                    </div>
                </header>

                @switch($service)
                    @case(\App\Enums\ServiceEnum::DATA)
                        @include('service.partials.fixed-price-form')
                    @break
                    @case(\App\Enums\ServiceEnum::AIRTIME)
                        @include('service.partials.discount-price-form')
                    @break
                @endswitch
            </x-card>
        </div>
    </div>
</x-app-layout>
