<div class="grid grid-cols-2 gap-1">
    @foreach($providers as $provider)
        <a href="{{route('services.index', ['service' => $service, 'provider' => $provider])}}"
           class="p-12 bg-blue-50 text-blue-800 rounded flex flex-col items-center gap-2 cursor-pointer hover:bg-blue-800 hover:text-blue-50 transition-all duration-300">
            {{--<span data-lucide="{{$service->getLucideIcon()}}"></span>--}}
            <strong class="text-lg">{{strtoupper($provider)}}</strong>
        </a>
    @endforeach
</div>
