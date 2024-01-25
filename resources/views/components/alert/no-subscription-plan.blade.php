@php
$hasPlan = request()->user()->subscription()->exists();
$willSoonExpire = request()->user()->subscription?->willSoonExpire();
@endphp
@if(!$hasPlan || $willSoonExpire)
    <div x-data="{ isOpen: true }" x-show="isOpen" class="{{$hasPlan ? 'bg-amber-500' : 'bg-red-700'}} text-white rounded p-4 flex items-center justify-between">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i data-lucide="alert-triangle" class="h-5 w-5"></i>
            </div>
            <div class="ml-3">
                @if(!$hasPlan)
                    <h4 class="font-semibold text-lg">No Subscription Plan</h4>
                    <p>You don't have an active subscription plan. Subscribe now to activate your website.</p>
                @else
                    <h4 class="font-semibold text-lg">Subscription Expiry</h4>
                    <p>
                        Your subscription is approaching its expiration. Kindly subscribe promptly to prevent any disruption to your account services.
                    </p>
                @endif
            </div>
        </div>
        <div>
            <!-- Subscribe button (replace with the actual link to your subscription page) -->
            <a href="{{route('site')}}">
                <x-secondary-button>Subscribe Now</x-secondary-button>
            </a>
            <!-- Dismiss button -->
            <button @click="isOpen = false" class="p-4">
                <!-- Lucide 'x' (close) icon with data-lucide attribute -->
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>
    </div>
@endif
