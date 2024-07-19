@if($attributes->has('href'))
    <a {{$attributes->merge(['class' => "inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500"])}}>
        {{$slot}}
    </a>
@else
    <button {{$attributes->merge(['class' => "inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500"])}}>
        {{$slot}}
    </button>
@endif
