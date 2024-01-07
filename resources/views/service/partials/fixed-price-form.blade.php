<form class="mt-8" method="post" action="{{route('services.update', $service)}}">
    @csrf
    @foreach($packages as $package)
        <!-- Package -->
        <div class="mt-4" x-data="{value:'{{old('form.' . $package->id, money($package->pivot->price)->formatByDecimal())}}'}">
            <x-input-label for="{{$package->id}}" value="{{$package->title}} = {{money($package->price)}}" />
            <x-text-input x-model="value" x-on:change="value=Number(value).toFixed(2)" id="{{$package->id}}" class="block mt-1 w-full" type="text" name="form[{{$package->id}}]" :value="old('form.' . $package->id, money($package->pivot->price)->formatByDecimal())" required autofocus/>
            <x-input-error :messages="$errors->get('form.' . $package->id)" class="mt-2" />
        </div>
    @endforeach

    <div class="mt-4">
        <x-primary-button>Update</x-primary-button>
    </div>
</form>
