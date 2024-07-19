<x-tenant::layouts.app title="Orders">
    <section class="px-4 pb-8">
        <div class=" flex flex-col divide-y divide-gray-200 dark:divide-neutral-700">
            @forelse($orders as $order)
                <button class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-gray-800 dark:text-white">
                    <div class="flex items-center justify-between w-full">
                        <div class="text-left">
                            <span class="font-medium">{{$order->description}}</span>
                            <span class="block text-slate-500 font-light text-xs">{{$order->created_at->diffForHumans()}}</span>
                        </div>
                        <span>{{money(abs($order->getTotal()))}}</span>
                    </div>
                </button>
            @empty
                <div class="py-12 text-slate-400">
                    <p class="text-center text-sm">No Orders</p>
                </div>
            @endforelse
        </div>
        @if(method_exists($orders, 'links'))
            <div class="py-4">
                {{$orders->links()}}
            </div>
        @endif
    </section>
</x-tenant::layouts.app>
