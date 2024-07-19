@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm dark:text-white']) }}>
    {{ $value ?? $slot }}
</label>
