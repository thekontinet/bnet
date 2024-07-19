@props([
    'title' => null,
    'content' => null,
    'icon' => null,
    'href' => null,
    'label' => null,
])

<!-- Card -->
<div {{$attributes->merge(['class' => "flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800"])}}>
    <div class="p-4 md:p-5 flex justify-between gap-x-3">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                {{$title}}
            </p>
            <div class="mt-1 flex items-center gap-x-2">
                <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                    {{$content}}
                </h3>
            </div>
        </div>
        @if($icon)
            <span class="flex-shrink-0 flex justify-center items-center size-[46px] bg-blue-600 text-white rounded-full dark:bg-blue-900 dark:text-blue-200">
                <x-dynamic-component :component="$icon"/>
            </span>
        @endif
    </div>

    @if($href)
        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800" href="{{$href}}">
            {{$label}}
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    @endif
</div>
<!-- End Card -->
