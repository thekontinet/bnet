<form method="post" action="{{route('services.update', $service)}}">
    @csrf
    @foreach($packages as $package)
        <!-- Package -->
        <div class="mt-4">
            <x-input-label for="{{$package->id}}" value="{{$package->title}} = {{($package->discount)}}% discount" />
            <x-text-input id="{{$package->id}}" class="block mt-1 w-full" type="text" name="form[{{$package->id}}]" :value="old('form.' . $package->id, $package->pivot->discount)" required autofocus/>
            <x-input-error :messages="$errors->get('form.' . $package->id)" class="mt-2" />
        </div>
    @endforeach

    <div class="mt-4">
        <x-primary-button>Update</x-primary-button>
    </div>
</form>
