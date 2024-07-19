@props(['title' => '', 'description' => '', 'action' => '', 'fields' => []])
<section {{$attributes}}>
    <header>
        <h2 class="text-lg font-bold">
            {{ __($title ?? null) }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __($description ?? null) }}
        </p>
    </header>


    <form method="post" action="{{ $action }}" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf

        @foreach($fields as $name => $field)
            <div>
                <x-input-label :for="$field->getAttribute('name')" :value="__($field->getAttribute('label'))" />
                @if($field->getAttribute('type') == 'file')
                    <x-file-input :id="$field->getAttribute('name')" name="{{$field->getAttribute('name')}}" :value="old($field->getAttribute('name'), asset('storage/' . $field->getAttribute('value')))"/>
                @else
                    <x-text-input :type="$field->getAttribute('type')"
                                  :id="$field->getAttribute('name')"
                                  :name="$field->getAttribute('name')"
                                  :value="old($field->getAttribute('name'), $field->getAttribute('value'))"
                                  :placeholder="$field->getAttribute('placeholder')"/>
                @endif
                <x-tenant::input-error class="mt-2" :messages="$errors->get($field->getAttribute('name'))" />
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-tenant::primary-button>{{ __('Save') }}</x-tenant::primary-button>
        </div>
    </form>
</section>
