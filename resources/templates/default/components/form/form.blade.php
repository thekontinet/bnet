@props(['title' => '', 'description' => '', 'action' => '', 'fields' => []])
<section {{$attributes}}>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __($title ?? null) }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __($description ?? null) }}
        </p>
    </header>


    <form method="post" action="{{ $action }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        @foreach($fields as $name => $field)
            <div>
                <x-input-label :for="$field->getAttribute('name')" :value="__($field->getAttribute('label'))" />
                @if($field->getAttribute('type') == 'file')
                    <x-file-input :id="$field->getAttribute('name')" name="{{$field->getAttribute('name')}}" class="mt-1 block w-full" :value="old($field->getAttribute('name'), asset('storage/' . $field->getAttribute('value')))"/>
                @else
                    <x-text-input :type="$field->getAttribute('type')"
                                  :id="$field->getAttribute('name')"
                                  :name="$field->getAttribute('name')"
                                  class="mt-1 block w-full"
                                  :value="old($field->getAttribute('name'), $field->getAttribute('value'))"
                                  :placeholder="$field->getAttribute('placeholder')"/>
                @endif
                <x-input-error class="mt-2" :messages="$errors->get($field->getAttribute('name'))" />
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
