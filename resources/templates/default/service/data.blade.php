<x-tenant::layouts.app>
    <x-tenant::appbar title="Purchase Airtime"/>

    <section class="pb-32 bg-white rounded-t-xl p-4 min-h-screen">
        <header class="mb-4">
            <h4 class="font-medium">Recharge Airtime</h4>
            {{--            <p class="text-sm">Update account information</p>--}}
        </header>

        <div class="flex flex-col justify-center">
            <form action="{{ route('tenant.package.purchase', $package) }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <x-tenant::input-label for="provider" value="Select Network"/>
                    <x-tenant::select-input class="w-full" name="package_id" id="provider" required="">
                        @foreach($packages as $package)
                            <option value="{{$package->id}}">{{ucfirst($package->title)}} = {{money($package->sellPrice())}}</option>
                        @endforeach
                    </x-tenant::select-input>
                    <x-tenant::input-error :messages="$errors->get('package_id')"/>
                </div>

                <div>
                    <x-tenant::input-label for="phone" value="Phone"/>
                    <x-tenant::text-input class="w-full" name="phone" id="phone" required=""/>
                    <x-tenant::input-error :messages="$errors->get('phone')"/>
                </div>

                <x-tenant::primary-button>Purchase</x-tenant::primary-button>
            </form>
        </div>
    </section>
</x-tenant::layouts.app>
