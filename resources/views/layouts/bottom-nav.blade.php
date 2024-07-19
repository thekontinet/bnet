<!-- Sidebar -->
<div class="duration-300 border transform h-full bg-white border-e border-gray-200 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="h-full flex flex-col justify-start items-center gap-y-2 py-2">
       <div class="flex justify-start items-center gap-x-8 px-8 mt-auto">
            @foreach($navitems as $name => $item)
                <div class="hs-tooltip [--placement:top] inline-block">
                    <a href="{{$item['href']}}" @class(['hs-tooltip-toggle w-12 h-12 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 hover:bg-gray-100 dark:hover:bg-neutral-700', 'bg-gray-100 dark:bg-neutral-700' => $item['active']])>
                        <x-dynamic-component component="{{$item['icon']}}" class="size-4"/>
                        <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip">
                      {{$name}}
                    </span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-auto">

        </div>

    </div>
</div>
<!-- End Sidebar -->
