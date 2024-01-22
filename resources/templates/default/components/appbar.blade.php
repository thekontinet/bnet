@props(['title'])
<header class="min-h-20">
    <div class="py-4 px-8 bg-white flex justify-between items-center mb-8 fixed inset-x-0 max-w-xl mx-auto border">
        <a href="{{route('tenant.dashboard')}}" class="p-2 grid place-items-center"><span data-lucide="chevron-left-square"></span></a>
        <h2 class="font-medium">{{$title}}</h2>
        <button></button>
    </div>
</header>
