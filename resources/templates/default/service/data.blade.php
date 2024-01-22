<x-tenant::layouts.app>
    <x-tenant::appbar title="Purchase Mobile Data"/>

    <section class="pb-32 bg-white rounded-t-xl p-4 min-h-screen">
        <header class="mb-4">
            <h4 class="font-medium">Recharge Mobile Data</h4>
            {{--            <p class="text-sm">Update account information</p>--}}
        </header>

        <div class="flex flex-col justify-center">
            <form method="post" class="space-y-4">
                @csrf

                <div>
                    <x-tenant::input-label for="phone" value="Phone"/>
                    <x-tenant::text-input class="w-full" name="phone" id="phone" required=""/>
                    <x-tenant::input-error :messages="$errors->get('phone')"/>
                </div>


                <div class="space-y-2 h-[200px] overflow-y-auto py-4">
                    @foreach($packages as $package)
                        <x-tenant::primary-button class="w-full" formaction="{{ route('tenant.package.purchase', $package) }}">
                            Purchase {{$package->title}}
                        </x-tenant::primary-button>
                    @endforeach
                </div>
            </form>
        </div>
    </section>
</x-tenant::layouts.app>
