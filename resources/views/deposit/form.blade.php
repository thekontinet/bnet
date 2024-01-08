<x-app-layout>
    <x-container>
        <x-card>
            <section class="max-w-xl mx-auto">
                <form action="{{route('deposit.pay')}}" method="post">
                    @csrf
                    <!-- Amount -->
                    <div class="mt-4" x-data="{value:'0.00'}">
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input class="block mt-1 w-full"
                                      name="amount"
                                      type="text"
                                      id="amount"
                                      x-model="value"
                                      x-on:change="value=Number(value).toFixed(2)"
                                      :value="old('amount')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>Pay Now</x-primary-button>
                    </div>
                </form>
            </section>
        </x-card>
    </x-container>
</x-app-layout>
