<x-guest-layout>
    <h2 class="font-medium text-lg">New Organization</h2>
    <p class="text-sm text-gray-400 mb-4">Complete the form create an organization</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('organizations.store') }}" class="space-y-4" x-data="{slug:@js(old('domain', ''))}">
        @csrf

        <div>
            <x-input-label for="org-name">Organization Name</x-input-label>
            <x-text-input
                x-on:change="slug = $el.value.normalize('NFKD')
                                    .replace(/[\u0300-\u036f]/g, '')
                                    .trim()
                                    .toLowerCase()
                                    .replace(/[^a-z0-9 -]/g, '')
                                    .replace(/\s+/g, '-')
                                    .replace(/-+/g, '-')"
                name="name"
                id="org-name"
                value="{{old('name')}}"
                placeholder="Organization Name" autofocus/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Domain Name -->
        <div>
            <x-input-label for="domain" :value="__('Domain')" />
            <x-text-input
                x-model="slug"
                id="domain"
                type="text"
                name="domain"
                value="{{old('domain')}}"
                autocomplete="username"
                suffix="{{config('app.default_domain_extension')}}"
                placeholder="example"
                required/>
            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="whatsapp">Whatsapp <span class="text-xs">(optional)</span></x-input-label>
            <x-text-input
                type="url"
                name="whatsapp"
                id="whatsapp"
                value="{{old('whatsapp')}}"
                placeholder="Facebook Profile Link">
                <x-slot name="prefix">
                    <x-bi-whatsapp class="size-4"/>
                </x-slot>
            </x-text-input>
            <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="facebook">Facebook <span class="text-xs">(optional)</span></x-input-label>
            <x-text-input
                type="url"
                name="facebook"
                id="facebook"
                value="{{old('facebook')}}"
                placeholder="Facebook Profile Link">
                <x-slot name="prefix">
                    <x-bi-facebook class="size-4"/>
                </x-slot>
            </x-text-input>
            <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="instagram">Instagram <span class="text-xs">(optional)</span></x-input-label>
            <x-text-input
                type="url"
                name="instagram"
                id="instagram"
                value="{{old('instagram')}}"
                placeholder="Facebook Profile Link">
                <x-slot name="prefix">
                    <x-bi-instagram class="size-4"/>
                </x-slot>
            </x-text-input>
            <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Proceed') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
