@props(['label', 'href', 'active'=>false, 'icon'])


<a href="{{ $href }}" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
    <span data-lucide="{{$icon}}" @class([
            "w-5 h-5 mb-2",
            'text-primary-600' => $active,
            'group-hover:text-primary-600' => !$active
    ])>
    </span>
    <span @class([
            "text-xs",
            "text-primary-600" => $active,
            "text-gray-500" => !$active
    ])>{{$label}}</span>
</a>
