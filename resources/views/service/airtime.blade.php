<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Airtime Price Settings') }}
            </h2>

            <x-primary-button type="submit" form="airtime-form" target="_blank">
                Save
            </x-primary-button>
        </div>
    </x-slot>

    <x-container>
        <form method="post" action="{{route('airtime.store')}}" id="airtime-form" class="grid sm:grid-cols-2 gap-4">
            @csrf
            @foreach($packages as $key => $package)
                <x-card>
                    <h4 class="text-lg font-semibold mb-4">{{$package->name}}</h4>
                    <div class="space-y-2">
                        <p class="mt-2 bg-blue-100 border border-blue-200 text-sm text-blue-800 rounded-lg p-4 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500">
                            You earn <strong class="font-bold text-lg">{{$package->discount}}%</strong> from every customer recharge. Your customer discount will be calculated from your earning
                        </p>
                        <div>
                            <x-input-label>Customer Discount (%)</x-input-label>
                            <x-text-input
                                type="number"
                                name="discount[{{$package->id}}]"
                                value="{{old('discount.'.$package->id, $tenant_package[$key]?->discount)}}"
                                suffix="%"
                                min="0"
                                max="{{$package->discount}}"/>
                            <x-input-error :messages='$errors->first("discount.$package->id")'/>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </form>
    </x-container>
</x-app-layout>
