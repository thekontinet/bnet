<section>
    <header>
        <h2 class="text-lg font-bold">
            {{ __('Manage Domain') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __("You can update your current domain")}}
        </p>
    </header>

    <form method="post" id="domain-reset-form">
        @csrf
        @method('DELETE')
    </form>

    <form method="post" action="{{ route('domains.store') }}" class="mt-6 space-y-6" id="domain-update">
        @csrf
        @method('PUT')
        <div>
            <x-input-label for="domain" :value="__('Your Current Domain')" />
            <x-text-input id="domain" name="domain" class="mt-1 block w-full" :value="old('domain', $tenant->domains->last()->domain)" autocomplete="domain" disabled/>
            <x-input-error :messages="$errors->domainCreated->get('domain')" class="mt-2" />
        </div>
    </form>


    <div class="flex items-center gap-4 mt-4">
        <x-primary-button form="domain-update">{{ __('Save') }}</x-primary-button>
        <x-secondary-button form="domain-reset-form" type="submit" form="domain-reset-form">{{ __('Revert') }}</x-secondary-button>

        @if (session('status') === 'domain-created')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('New domain added.') }}</p>
        @endif

        @if (session('status') === 'domain-reset')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Domain reset complete.') }}</p>
        @endif
    </div>
</section>
