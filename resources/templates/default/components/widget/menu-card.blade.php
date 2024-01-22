<a href="{{ $url }}" class="flex flex-col w-full h-full overflow-hidden bg-white items-center gap-1 group">
    <span class="p-2 transition-all group-hover:bg-blue-200 group-hover:text-blue-800 rounded-full"><span {{$attributes->get('icon')}} class="size-5"></span></span>
    <span class="text-xs font-semibold group-hover:text-blue-600">{{$label}}</span>
</a>
