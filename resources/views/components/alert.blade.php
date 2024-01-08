@if(session('message'))
    <div class="relative text-green-500 bg-green-300" x-data="{show: true}" x-show="show">
        <div class="p-4 max-w-7xl px-8 mx-auto relative">
            <p>{{session('message')}}</p>
            <button @click="show=false" class="absolute top-1/2 -translate-y-1/2 right-8"><i data-lucide="x" class="size-4"></i></button>
        </div>
    </div>
@endif


@if(session('error'))
<div class="relative text-red-500 bg-red-300" x-data="{show: true}" x-show="show">
    <div class="p-4 max-w-7xl px-8 mx-auto relative">
        <p>{{session('error')}}</p>
        <button @click="show=false" class="absolute top-1/2 -translate-y-1/2 right-8"><i data-lucide="x" class="size-4"></i></button>
    </div>
</div>
@endif
