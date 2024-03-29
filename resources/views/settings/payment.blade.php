<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Settings') }}
        </h2>
        <p>Manage payment options for your customers</p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($forms as $form)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('settings.partials.update-preference-form', ['form' => $form])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
