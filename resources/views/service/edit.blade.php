<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <form method="post" action="{{route('services.update', $service)}}">
                    @csrf
                    @foreach($packages as $package)
                        @if($package->isFixedPriceType())
                            <div class="mt-4">
                                <x-input-label for="{{$package->id}}" value="{{$package->label}}"/>
                                <x-money-input id="{{$package->id}}" class="block mt-1 w-full" type="text"
                                               name="fixed[{{$package->id}}]"
                                               :value="old('fixed.' . $package->id, money($package->pivot->price)->formatByDecimal())"
                                               required autofocus/>
                                <x-input-error :messages="$errors->get('fixed.' . $package->id)" class="mt-2"/>
                            </div>
                        @else
                            <div class="mt-4">
                                <x-input-label for="{{$package->id}}" value="{{$package->label}}"/>
                                <x-text-input id="{{$package->id}}" class="block mt-1 w-full" type="text"
                                              name="discount[{{$package->id}}]"
                                              :value="old('discount.' . $package->id, $package->pivot->discount)"
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('discount.' . $package->id)" class="mt-2"/>
                            </div>
                        @endif
                    @endforeach
                    <div class="mt-4">
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
