<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Website Settings') }}
        </h2>
    </x-slot>

    <x-container>
        <div class="max-w-2xl">
            <form method="post" action="{{ route('business') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Brand Name')" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $tenant->config->get('name'))" autocomplete="name" />
                    <x-input-error :messages="$errors->websiteUpdated->get('name')" class="mt-2" />
                </div>

                <div x-data="{value:'{{old('description', $tenant->config->get('description'))}}'}">
                    <x-input-label for="description" :value="__('Brand Description')" />
                    <x-text-input x-model="value" maxlength="150" id="description" name="description" class="mt-1 block w-full" :value="old('description', $tenant->config->get('description'))" autocomplete="brand_name" />
                    <x-input-error :messages="$errors->websiteUpdated->get('description')" class="mt-2" />
                    <span class="text-sm block text-right" x-text="value.length + '/150'"></span>
                </div>

                <div>
                    <x-input-label for="whatsapp" :value="__('Whatsapp')" />
                    <x-text-input id="whatsapp" name="whatsapp" class="mt-1 block w-full" :value="old('whatsapp', $tenant->config->get('social.whatsapp'))" autocomplete="whatsapp" />
                    <x-input-error :messages="$errors->websiteUpdated->get('whatsapp')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="facebook" :value="__('Facebook')" />
                    <x-text-input id="facebook" name="facebook" class="mt-1 block w-full" :value="old('facebook', $tenant->config->get('social.facebook'))" autocomplete="facebook" />
                    <x-input-error :messages="$errors->websiteUpdated->get('facebook')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="instagram" :value="__('Instagram')" />
                    <x-text-input id="instagram" name="instagram" class="mt-1 block w-full" :value="old('instagram', $tenant->config->get('social.instagram'))" autocomplete="instagram" />
                    <x-input-error :messages="$errors->websiteUpdated->get('instagram')" class="mt-2" />
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
        </div>
    </x-container>
</x-app-layout>
