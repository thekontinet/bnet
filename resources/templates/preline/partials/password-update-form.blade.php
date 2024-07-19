<form action="{{route('tenant.password.update')}}" method="post" class="space-y-4 px-4">
    @csrf
    <div>
        <x-template::input-label>Current Password</x-template::input-label>
        <x-template::text-input type="password" name="current_password" value="{{old('current_password')}}" />
        <x-template::input-error :messages="$errors->password->get('current_password')" />
    </div>

    <div>
        <x-template::input-label>New Password</x-template::input-label>
        <x-template::text-input type="password" name="password" value="{{old('password')}}" />
        <x-template::input-error :messages="$errors->password->get('password')" />
    </div>

    <div>
        <x-template::input-label>Confirm Password</x-template::input-label>
        <x-template::text-input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" />
        <x-template::input-error :messages="$errors->password->get('password_confirmation')" />
    </div>

    <x-template::primary-button class="w-full">Submit</x-template::primary-button>
</form>
