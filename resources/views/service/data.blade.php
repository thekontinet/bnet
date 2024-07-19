<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Data Price Settings') }}
            </h2>

            <x-primary-button type="submit" form="airtime-form" target="_blank">
                Save
            </x-primary-button>
        </div>
    </x-slot>

    <x-container>
        @php
            $items = ['mtn', 'glo', 'airtel', '9mobile'];
            $packages = $packages->where('provider', $provider)
        @endphp
        <ul class="flex space-x-2">
            @foreach($items as $item)
                @if(strtolower($provider) === $item)
                <li class="basis-0 grow">
                    <a href="{{route('data.index', ['network' => $item])}}" aria-current="page" class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 bg-blue-600 text-sm font-medium text-center text-white rounded-lg">
                        {{strtoupper($item)}}
                    </a>
                </li>
                @else
                <li class="basis-0 grow">
                    <a href="{{route('data.index', ['network' => $item])}}" aria-current="page" class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500">
                        {{strtoupper($item)}}
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
    </x-container>

    <x-container>
        <form method="post" action="{{route('data.store')}}" id="airtime-form" class="grid sm:grid-cols-2 gap-4">
            @csrf
            @foreach($packages as $key => $package)
                <x-card>
                    <h4 class="text-lg font-semibold mb-4">{{$package->name}}</h4>
                    <div class="space-y-2">
                        <p class="mt-2 bg-blue-100 border border-blue-200 text-sm text-blue-800 rounded-lg p-4 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500">
                            The purchase price for <strong class="font-bold text-lg">{{$package->name}}</strong> is <strong class="font-bold text-lg">{{money($package->price)}}</strong>. Sell at a higher amount to make profit
                        </p>
                        <div>
                            <x-input-label>Seles Price</x-input-label>
                            <x-text-input
                                type="number"
                                name="prices[{{$package->id}}]"
                                value="{{old('prices.'.$package->id, money($tenant_package[$key]?->price)->formatByDecimal())}}"
                                prefix="₦"
                                min="{{money($package->price)->formatByDecimal()}}"/>
                            <x-input-error :messages='$errors->first("prices.$package->id")'/>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </form>
    </x-container>
</x-app-layout>
