<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Services') }}
            </h2>

            <x-link href="{{route('dashboard')}}" target="_blank">
                Back
            </x-link>
        </div>
    </x-slot>

    <section class="p-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-1">
            @foreach($services as $service)
                <!-- Card -->
                <a class="group flex flex-col bg-white border shadow-sm rounded hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="{{route($service->value . '.index')}}">
                    <div class="p-4 md:p-5">
                        <div class="flex">
                            <span data-lucide="{{$service->getLucideIcon()}}"></span>

                            <div class="grow ms-5">
                                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                    {{$service->name}}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-neutral-500">
                                    Service
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            @endforeach
        </div>
    </section>
</x-app-layout>
