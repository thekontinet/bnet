@props(['disabled' => false])

<div x-data="{value: {{money($attributes->get('value'))->formatByDecimal() ?? '0'}}.toFixed(2)}">
    <input x-on:change="value=Number(value).toFixed(2)" x-model="value" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
</div>
