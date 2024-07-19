<x-app-layout>
    <x-slot name="header">
        @if($tenant->subscription()->exists() && !$tenant->subscription?->expired())
            <div class="bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                    </div>
                    <div class="flex-1 md:flex md:justify-between ms-2">
                        <p class="text-sm">
                            Currently subscribe to <strong>{{$tenant->subscription->plan->title}}</strong>
                        </p>
                        <p class="text-sm mt-3 md:mt-0 md:ms-6">
                            <span class="text-gray-800 hover:text-gray-500 font-medium whitespace-nowrap dark:text-neutral-200 dark:hover:text-neutral-400">
                                Ends {{$tenant->subscription?->expires_at->format('jS M Y') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </x-slot>

    <x-container>
        <div class="relative">
            <!-- Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                @foreach($plans as $plan)
                    <div>
                        <!-- Card -->
                        <div class="shadow-xl shadow-gray-200 p-5 relative z-10 bg-white border rounded-xl md:p-10 dark:bg-neutral-900 dark:border-neutral-800 dark:shadow-gray-900/20">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{$plan->title}}</h3>
                            <div class="text-sm text-gray-500 dark:text-neutral-500">{{str($plan->interval)->plural($plan->duration)->ucfirst()->prepend($plan->duration)}}</div>
                            @if($tenant->subscription?->plan_id == $plan->id)
                                <span class="absolute top-0 end-0 rounded-se-xl rounded-es-xl text-xs font-medium bg-gray-800 text-white py-1.5 px-3 dark:bg-white dark:text-neutral-800">Active</span>
                            @endif

                            <div class="mt-5">
                                <span class="text-4xl font-bold text-gray-800 dark:text-neutral-200">{{money($plan->price)}}</span>
                                <span class="ms-3 text-gray-500 dark:text-neutral-500"></span>
                            </div>

                            @if((int) $plan->getKey() !== (int) $tenant->subscription?->plan_id || $tenant->subscription?->expiring() || $tenant->subscription?->expired())
                                <form method="post" action="{{ route('subscribe.store') }}" class="mt-1 space-y-6"
                                      onsubmit="return confirm('You are about to upgrade your plan. Are you sure of this action ?')">
                                    @csrf
                                    <x-primary-button value="{{$plan->id}}" name="plan_id">Subscribe</x-primary-button>
                                </form>
                            @endif
                        </div>
                        <!-- End Card -->
                    </div>
                @endforeach
            </div>
            <!-- End Grid -->
        </div>
    </x-container>
</x-app-layout>
