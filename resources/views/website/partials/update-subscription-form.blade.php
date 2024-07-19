@inject('subscriptionService', App\Services\SubscriptionService::class)
<section class="p-2">
    <header class="max-w-2xl mb-8 lg:mb-14">
        <h2 class="text-3xl lg:text-2xl text-gray-800 font-bold dark:text-neutral-200">
            Pricing Plan
        </h2>
    </header>

    <div class="relative">
        <!-- Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            @foreach(\App\Models\Plan::all() as $plan)
                <div>
                    <!-- Card -->
                    <div class="shadow-xl shadow-gray-200 p-5 relative z-10 bg-white border rounded-xl md:p-10 dark:bg-neutral-900 dark:border-neutral-800 dark:shadow-gray-900/20">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{$plan->title}}</h3>
                        @if(!$subscriptionService->subscriptionHasExpired($tenant->subscription))
                            <div class="text-sm text-gray-500 dark:text-neutral-500">Expires {{$tenant->subscription?->expires_at->diffForHumans() }}</div>
                        @endif
                        @if($tenant->subscription?->plan_id == $plan->id)
                        <span class="absolute top-0 end-0 rounded-se-xl rounded-es-xl text-xs font-medium bg-gray-800 text-white py-1.5 px-3 dark:bg-white dark:text-neutral-800">Active</span>
                        @endif

                        <div class="mt-5">
                            <span class="text-4xl font-bold text-gray-800 dark:text-neutral-200">{{money($plan->price)}}</span>
                            <span class="ms-3 text-gray-500 dark:text-neutral-500">{{str($plan->interval)->plural($plan->duration)->ucfirst()->prepend($plan->duration)}}</span>
                        </div>

                        <form method="post" action="{{ route('subscribe.store') }}" class="mt-1 space-y-6"
                              onsubmit="return confirm('You are about to upgrade your plan. Are you sure of this action ?')">
                            @csrf
                            <button value="{{$plan->id}}" name="plan_id" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Subscribe</button>
                        </form>
                    </div>
                    <!-- End Card -->
                </div>
            @endforeach
        </div>
        <!-- End Grid -->
    </div>
</section>
