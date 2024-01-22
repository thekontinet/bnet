<x-tenant::layouts.app>
    <x-tenant::appbar title="Settings"/>

    <section class="p-4">
        <header class="mb-4">
            <h4 class="font-medium">Account Settings</h4>
            <p class="text-sm">Update account information</p>
        </header>

        <form action="{{ route('tenant.profile.update') }}" method="post" class="space-y-4">
            @csrf
            <div>
                <x-tenant::input-label for="firstname" value="Firstname"/>
                <x-tenant::text-input class="w-full" name="firstname" id="firstname" :value="old('firstname', $user->firstname)" required=""/>
                <x-tenant::input-error :messages="$errors->get('firstname')"/>
            </div>

            <div>
                <x-tenant::input-label for="lastname" value="Lastname"/>
                <x-tenant::text-input class="w-full" name="lastname" id="lastname" :value="old('lastname', $user->lastname)" required=""/>
                <x-tenant::input-error :messages="$errors->get('lastname')"/>
            </div>

            <div>
                <x-tenant::input-label for="email" value="Firstname"/>
                <x-tenant::text-input class="w-full" type="email" name="email" id="email" :value="old('email', $user->email)" required="" :disabled="true"/>
                <x-tenant::input-error :messages="$errors->get('email')"/>
            </div>

            <div>
                <x-tenant::input-label for="phone" value="Phone"/>
                <x-tenant::text-input class="w-full" name="phone" id="phone" :value="old('phone', $user->phone)" required=""/>
                <x-tenant::input-error :messages="$errors->get('phone')"/>
            </div>

            <x-tenant::primary-button>Update</x-tenant::primary-button>
        </form>
    </section>
</x-tenant::layouts.app>
