<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Choose Your Plan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">Select the perfect subscription plan for your business</p>
        <p class="mt-2 text-amber-600 text-sm">
            {{  $tenant->activePlan ? '' : 'No active subscription' }}
        </p>

        @if($tenant->activePlan)
            <p class="mt-1 text-sm text-gray-600">
                Expires: <strong class="text-cyan-500">{{$tenant->subscription?->expires_at->diffForHumans() }}</strong>
            </p>
        @endif

        <p class="mt-1 text-sm text-gray-600">
        </p>
    </header>

    {{--TODO: Add notification so users will know when plan is expiring--}}

    <form method="post" action="{{ route('subscribe.store') }}" class="mt-6 space-y-6"
          onsubmit="return confirm('You are about to upgrade your plan. Are you sure of this action ?')">
        @csrf

        <div>
            {{--TODO: add alert for subscription expiry notification--}}
            <x-input-label for="plan" :value="__('Select Plan')"/>
            <x-select-input name="plan_id">
                <option value="">Choose A Plan</option>
                @foreach(\App\Models\Plan::all() as $plan)
                    <option
                        value="{{$plan->id}}" {{$tenant->activePlan?->id == $plan->id ? 'selected' : false}}>{{$plan->price}}
                        for {{$plan->title}}
                        - {{str($plan->interval)->plural($plan->duration)->ucfirst()->prepend($plan->duration)}}</option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('plan')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upgrade') }}</x-primary-button>
        </div>
    </form>
</section>
