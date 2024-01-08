<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Current Plan:') }} {{$user->subscription?->plan?->title ?? 'NONE'}}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            <strong class="text-cyan-500">{{ __("Expires at: ") . $user->subscription?->expires_at->format('jS M Y') }}</strong>
        </p>

        <p class="mt-1 text-sm text-gray-600">
        </p>
    </header>

    {{--TODO: Add notification so users will know when plan is expiring--}}

    <form method="post" action="{{ route('subscribe.store') }}" class="mt-6 space-y-6" onsubmit="return confirm('You are about to upgrade your plan. Are you sure of this action ?')">
        @csrf

        <div>
            <x-input-label for="plan" :value="__('Select Plan')" />
{{--            <x-text-input id="plan" name="plan" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="plan" />--}}
            <select name="plan_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @foreach(\App\Models\Plan::all() as $plan)
                    <option value="{{$plan->id}}" {{$user->subscription?->plan_id == $plan->id ? 'selected' : false}}>{{$plan->price}} for {{$plan->title}} - {{str($plan->interval)->plural($plan->duration)->ucfirst()->prepend($plan->duration)}}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('plan')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upgrade') }}</x-primary-button>
        </div>
    </form>
</section>
