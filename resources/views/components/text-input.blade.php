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

<div>
    <div>
        <div class="relative">
            <input
                {{ $disabled ? 'disabled' : '' }}
                {!! $attributes->merge(['class' => implode(' ', $classes)]) !!}>
            @if($prefix)
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                 <span class="text-gray-500 dark:text-neutral-500">{{$prefix}}</span>
            </div>
            @endif

            @if($suffix)
            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4">
                <span class="text-gray-500 dark:text-neutral-500">{{$suffix}}</span>
            </div>
            @endif
        </div>
    </div>
</div>
