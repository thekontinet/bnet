<div class="grid grid-cols-2 gap-1">
    @foreach(\App\Enums\ServiceEnum::cases() as $service)
        <a href="{{route('services.index', ['service' => $service])}}"
           class="p-12 bg-blue-50 text-blue-800 rounded flex flex-col items-center gap-2 cursor-pointer hover:bg-blue-800 hover:text-blue-50 transition-all duration-300">
            <span data-lucide="{{$service->getLucideIcon()}}"></span>
            <strong>{{$service->name}}</strong>
        </a>
    @endforeach
</div>
