<div>
    <nav class="relative mt-2 z-0 flex border rounded-xl overflow-hidden dark:border-neutral-700" aria-label="Tabs" role="tablist">
        <button type="button" class="hs-tab-active:border-b-primary-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-primary-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400 {{$errors->isEmpty() ? 'active' : ''}}" id="bar-with-underline-item-1" data-hs-tab="#bar-with-underline-1" aria-controls="bar-with-underline-1" role="tab">
            Manual
        </button>

        <button type="button" class="hs-tab-active:border-b-primary-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-primary-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400 {{$errors->isNotEmpty() ? 'active' : ''}}" id="bar-with-underline-item-2" data-hs-tab="#bar-with-underline-2" aria-controls="bar-with-underline-2" role="tab">
            Auto
        </button>
    </nav>

    <div class="mt-3">
        <!-- Manual Tab -->
        <div id="bar-with-underline-1" class=" {{$errors->isNotEmpty() ? 'hidden' : ''}}" role="tabpanel" aria-labelledby="bar-with-underline-item-1">
            @if(config('tenant.app.bank.account_number'))
                <div class="bg-white p-4 rounded">
                    <div class="text-primary-800 flex border overflow-hidden bg-primary-50 rounded-lg">
                        <div class="bg-primary-500 text-white p-4 grid place-items-center">
                            <x-bi-bank class="size-6"/>
                        </div>
                        <p class="flex-1 text-sm p-4">{{config('tenant.app.bank.info')}}</p>
                    </div>

                    <ul class="mt-2">
                        <li class="flex items-center justify-between gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200"><strong class="font-medium">Bank Name:</strong> <span>{{config('tenant.app.bank.name')}}</span></li>
                        <li class="flex items-center justify-between gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200"><strong class="font-medium">Account Name:</strong> <span>{{config('tenant.app.bank.account_name')}}</span></li>
                        <li class="flex items-center justify-between gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200"><strong class="font-medium">Account Number:</strong> <span>{{config('tenant.app.bank.account_number')}}</span></li>
                    </ul>


                    <a href="https://wa.me/{{tenant('phone')}}" class="block">
                        <x-template::primary-button class="mt-4">Contact Admin</x-template::primary-button>
                    </a>
                </div>
            @else
                <p class="text-sm p-4 text-center">Not Available</p>
            @endif
        </div>

        <!-- Automatic Tab -->
        <div id="bar-with-underline-2" class="{{$errors->isEmpty() ? 'hidden' : ''}}" role="tabpanel" aria-labelledby="bar-with-underline-item-2">
            @if(config('tenant.app.paystack.secret'))
                <form action="{{route('tenant.payment.new')}}" method="post">
                    @csrf
                    <!-- Amount -->
                    <div x-data="{value:'0.00'}">
                        <x-tenant::input-label for="amount" :value="__('Amount')" />
                        <x-tenant::text-input class="block mt-1 w-full"
                                              name="amount"
                                              type="text"
                                              id="amount"
                                              x-model="value"
                                              wire:model="amount"
                                              x-on:change="value=Number(value).toFixed(2)"
                                              :value="old('amount')"
                                              required autofocus/>
                        <x-tenant::input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-tenant::primary-button>Pay Now</x-tenant::primary-button>
                    </div>
                </form>
            @else
                <p class="text-sm p-4 text-center">Not Available</p>
            @endif
        </div>
    </div>
</div>
