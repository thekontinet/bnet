@props([
    'title',
    'icon',
    'href',
    'active' => false
])


<li>
    <a @class([
        'flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-700 dark:text-white',
        'bg-gray-100' => $active
    ]) href="{{$href}}">
        <x-dynamic-component :component="$icon" class="size-5"/>
        {{$title}}
    </a>
</li>
