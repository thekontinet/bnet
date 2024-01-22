<form action="{{route('tenant.deposit')}}" method="post">
    @csrf
    <!-- Amount -->
    <div class="mt-4" x-data="{value:'0.00'}">
        <x-tenant::input-label for="amount" :value="__('Amount')" />
        <x-tenant::text-input class="block mt-1 w-full"
                              name="amount"
                              type="text"
                              id="amount"
                              x-model="value"
                              x-on:change="value=Number(value).toFixed(2)"
                              :value="old('amount')"
                              required autofocus/>
        <x-tenant::input-error :messages="$errors->get('amount')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-tenant::primary-button>Pay Now</x-tenant::primary-button>
    </div>
</form>
