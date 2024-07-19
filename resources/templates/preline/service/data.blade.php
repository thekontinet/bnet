<x-template::layouts.app title="Purchase Airtime">
    <section class="p-4">
        <form action="{{route('tenant.data-plan.store')}}" method="post" class="space-y-4" x-data="{package:null}">
            @csrf
            <div x-show="package" x-cloak>
                <x-tenant::input-label for="amount" :value="__('Phone')" />
                <x-tenant::text-input type="tel" name="phone" required />
                <x-tenant::input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="grid gap-4">
                @foreach($packages as $provider => $package)
                    <x-tenant::secondary-button class="w-full py-4" type="button" data-hs-overlay="#{{'panel-' . $provider}}" x-cloak x-show="!package">
                        {{strtoupper($provider)}}
                    </x-tenant::secondary-button>

                    <x-template::overlays.drawer name="{{'panel-' . $provider}}" class="mx-auto max-w-xl max-h-[50svh] overflow-y-auto">
                        <x-slot name="icon">
                            <x-tenant::primary-button data-hs-overlay="#{{'panel-' . $provider}}" type="button" class="w-full" x-cloak x-show="package">
                                Proceed
                            </x-tenant::primary-button>
                        </x-slot>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 p-4">
                            @foreach($package as $item)
                                <label for="input-{{$item['id']}}" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                    <input x-model="package" type="radio" name="package_code" value="{{$item['id']}}" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="input-{{$item['id']}}">
                                    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                                        {{str_replace('|', ' ', $item['name'])}} <br> {{money($item['price'])}}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </x-template::overlays.drawer>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-2">
                <x-template::primary-button class="w-full" x-cloak x-show="package">Send</x-template::primary-button>
                <x-template::secondary-button type="button" class="w-full" x-cloak x-show="package" x-on:click="package = null">Cancel</x-template::secondary-button>
            </div>
        </form>
    </section>
</x-template::layouts.app>
