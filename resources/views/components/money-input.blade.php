@props([
    'disabled' => false,
    'prefix' => null,
    'suffix' => null,
 ])

@php
    $classes = [
        $prefix ? 'ps-9' : '',
        $suffix ? 'pe-16' : '',
        'py-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600'
    ];
@endphp

<div x-data="{value: {{money($attributes->get('value'))->formatByDecimal() ?? '0'}}.toFixed(2)}">
    <input x-on:change="value=Number(value).toFixed(2)" x-model="value" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => implode(' ',  $classes)]) !!}>
</div>
