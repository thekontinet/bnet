<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Current Plan:') }} {{$tenant->subscription?->plan?->title ?? 'NONE'}}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            <strong class="text-cyan-500">{{ __("Expires at: ") . $tenant->subscription?->expires_at->format('jS M Y') }}</strong>
        </p>

        <p class="mt-1 text-sm text-gray-600">
        </p>
    </header>

    {{--TODO: Add notification so users will know when plan is expiring--}}

    <form method="post" action="{{ route('subscribe.store') }}" class="mt-6 space-y-6" onsubmit="return confirm('You are about to upgrade your plan. Are you sure of this action ?')">
        @csrf

        <div>
            <x-input-label for="plan" :value="__('Select Plan')" />
{{--            <x-text-input id="plan" name="plan" type="text" class="mt-1 block w-full" :value="old('name', $tenant->name)" required autofocus autocomplete="plan" />--}}
            <x-select-input name="plan_id">
                @foreach(\App\Models\Plan::all() as $plan)
                    <option value="{{$plan->id}}" {{$tenant->subscription?->plan_id == $plan->id ? 'selected' : false}}>{{$plan->price}} for {{$plan->title}} - {{str($plan->interval)->plural($plan->duration)->ucfirst()->prepend($plan->duration)}}</option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('plan')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upgrade') }}</x-primary-button>
        </div>
    </form>
</section>
