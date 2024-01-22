@props(['disabled' => false])
<div x-data="{ imageSrc: '{{ $attributes->get('value') }}' }">
    <x-image ::src="imageSrc" alt="logo" class="w-24 mb-4" />
    <input
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['type' => 'file', 'class' => '']) !!}
        x-ref="file"
        x-on:change = "imageSrc = $refs.file.files.length ? URL.createObjectURL($refs.file.files[0]) : '{{ $attributes->get('value') }}'"
    >
</div>
