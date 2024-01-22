<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Website') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update website information') }}
        </p>
    </header>

    <form method="post" action="{{ route('site') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="logo" :value="__('Logo')" />
            <x-file-input id="logo" name="logo" value="{{$tenant->getLogoUrl()}}" />
            <x-input-error :messages="$errors->websiteUpdated->get('logo')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="brand_name" :value="__('Brand Name')" />
            <x-text-input id="brand_name" name="brand_name" class="mt-1 block w-full" :value="old('brand_name', $tenant->brand_name)" autocomplete="brand_name" />
            <x-input-error :messages="$errors->websiteUpdated->get('brand_name')" class="mt-2" />
        </div>

        <div x-data="{value:'{{old('brand_description', $tenant->brand_description)}}'}">
            <x-input-label for="brand_description" :value="__('Brand Description')" />
            <x-text-input x-model="value" maxlength="150" id="brand_description" name="brand_description" class="mt-1 block w-full" :value="old('brand_description', $tenant->brand_description)" autocomplete="brand_name" />
            <x-input-error :messages="$errors->websiteUpdated->get('brand_description')" class="mt-2" />
            <span class="text-sm block text-right" x-text="value.length + '/150'"></span>
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'website-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
