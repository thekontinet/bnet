<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card class="p-6 text-gray-900">
                <header class="mb-4">
                    <h1 class="font-medium text-lg">ALL Services</h1>
                </header>
                <ul>
                    @foreach(\App\Enums\ServiceEnum::cases() as $service)
                        <li>
                            <a href="{{route('services.edit', $service)}}"
                               class="p-4 rounded flex items-center gap-2 cursor-pointer hover:bg-slate-100">
                                <span data-lucide="{{$service->getLucideIcon()}}"></span>
                                <strong>{{$service->name}}</strong>
                                <span class="w-4 h-4 ml-auto" data-lucide="arrow-right"></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </x-card>
        </div>
    </div>
</x-app-layout>
