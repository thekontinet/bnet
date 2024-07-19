<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __($form['title'] ?? null) }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __($form['description'] ?? null) }}
        </p>
    </header>


    <form method="post" action="{{ $form['action'] }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        @foreach($form['fields'] ?? [] as $name => $field)
            <div>
                <x-input-label :for="$field['name']" :value="__($field['label'])" />
                @if(($field['type'] ?? 'text') == 'file')
                    <x-file-input :id="$field['name']" name="{{$field['name']}}" class="mt-1 block w-full" :value="old($field['name'], asset('storage/' . $user->settings()->get($field['name'])))"/>
                @else
                    <x-text-input type="{{$field['type']}}" :id="$field['name']" name="{{$field['name']}}" class="mt-1 block w-full" :value="old($field['name'], $field['value'] ?? $user->settings()->get($field['name']))"/>
                @endif
                <x-input-error class="mt-2" :messages="$errors->get($field['name'])" />
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
