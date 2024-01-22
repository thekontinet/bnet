<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Manage Domain') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setup your domain name') }}
        </p>
    </header>

    <form method="post" action="{{ route('domain') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="domain" :value="__('New Domain')" />
            <x-text-input id="domain" name="domain" class="mt-1 block w-full" :value="old('domain', $tenant->domains->last()->domain)" autocomplete="domain" />
            <x-input-error :messages="$errors->domainCreated->get('domain')" class="mt-2" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <x-secondary-button type="submit" form="domain-reset-form">{{ __('Revert') }}</x-secondary-button>

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
    </form>
    <form action="{{route('domain')}}" method="post" id="domain-reset-form">
        @csrf
        @method('PUT')
    </form>
</section>
