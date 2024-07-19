@props(['message', 'status'])

@php
    $classes = [
        'danger' => 'bg-red-50 border border-red-200 text-red-800 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500',
        'success' => 'bg-teal-50 border border-teal-200 text-teal-800 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500',
    ];
    $buttonClasses = [
        'danger' => 'bg-red-50 text-red-500 hover:bg-red-100 focus:ring-offset-red-50 focus:ring-red-600 dark:hover:bg-red-800/50 dark:text-red-600',
        'success' => 'bg-teal-50 text-teal-500 hover:bg-teal-100 focus:ring-offset-teal-50 focus:ring-teal-600 dark:hover:bg-teal-800/50 dark:text-teal-600',
    ];
@endphp

@if($message)
    <div id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 rounded-lg p-4 {{ $classes[$status] ?? $classes['success'] }}" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
            </div>
            <div class="ms-2">
                <div class="text-sm font-medium">
                    {{$message}}
                </div>
            </div>
            <div class="ps-3 ms-auto">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" class="inline-flex rounded-lg p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $buttonClasses[$status] ?? $buttonClasses['success'] }}" data-hs-remove-element="#dismiss-alert">
                        <span class="sr-only">Dismiss</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
