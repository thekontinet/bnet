<form action="{{route('tenant.profile.update')}}" method="post" class="space-y-4 px-4">
    @csrf
    <div>
        <x-template::input-label>Firstname</x-template::input-label>
        <x-template::text-input name="firstname" value="{{old('firstname', $user->firstname)}}" />
        <x-template::input-error :messages="$errors->profile->get('firstname')" />
    </div>

    <div>
        <x-template::input-label>Lastname</x-template::input-label>
        <x-template::text-input name="lastname" value="{{old('lastname', $user->lastname)}}" />
        <x-template::input-error :messages="$errors->profile->get('lastname')" />
    </div>

    <div>
        <x-template::input-label>Email</x-template::input-label>
        <x-template::text-input type="email" name="email" value="{{old('email', $user->email)}}" />
        <x-template::input-error :messages="$errors->profile->get('email')" />
    </div>

    <div>
        <x-template::input-label>Phone</x-template::input-label>
        <x-template::text-input type="tel" name="phone" value="{{old('phone', $user->phone)}}" />
        <x-template::input-error :messages="$errors->profile->get('phone')" />
    </div>

    <x-template::primary-button class="w-full">Update</x-template::primary-button>
</form>
