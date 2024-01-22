<x-tenant::layouts.app>
    <x-tenant::appbar title="Fund Wallet"/>
    <section class="max-w-xl mx-auto px-2 space-y-4">
        @if(tenant()->settings()->get(\App\Enums\Config::PAYSTACK_SECRET->value))
            <div class="bg-white p-4 rounded">
                @include('template::deposit.partials.automatic-payment-form')
            </div>
        @endif

        <div class="bg-white p-4 rounded">
            @include('template::deposit.partials.manual-payment-form')
        </div>
    </section>
</x-tenant::layouts.app>
