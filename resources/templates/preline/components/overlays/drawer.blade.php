@props([
    'position' => 'bottom',
    'name' => null,
    'header' => null,
    'icon' => null,
    'active' => false
])

@php
    $baseClass = 'hs-overlay fixed transition-all duration-300 transform z-[80] bg-white dark:bg-neutral-800 dark:border-neutral-700';

    $positionClasses = match ($position) {
        'top' => 'hs-overlay-open:translate-y-0 top-0 inset-x-0 -translate-y-full max-h-80 border-b',
        'right' => 'hs-overlay-open:translate-x-0 top-0 end-0 translate-x-full h-full max-w-xs w-full border-s',
        'bottom' => 'hs-overlay-open:translate-y-0 bottom-0 inset-x-0 translate-y-full max-h-4xl border-b',
        'left' => 'hs-overlay-open:translate-x-0 top-0 start-0 -translate-x-full h-full max-w-xs w-full border-e',
        default => '',
    };

    $classNames = implode(' ', [$baseClass, $positionClasses, $active ? 'open opened' : 'hidden'])
@endphp

<div id="{{$name}}" {{$attributes->merge(['class' => $classNames])}} tabindex="-1">
    <div class="flex justify-between items-center py-3 px-4 dark:border-neutral-700 sticky inset-x-0 top-0">
        {{$header}}
        <button type="button" class="ml-auto flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#{{$name}}">
            @if($icon)
                {{$icon}}
            @else
                <span class="sr-only">Close modal</span>
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            @endif
        </button>
    </div>
    {{$slot}}
</div>
