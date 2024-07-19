<x-tenant::layouts.app class="bg-white">
    <x-tenant::appbar title="Transactions"/>

    <section class="py-4 bg-white space-y-4">
        <ul class="space-y-2 h-full overflow-y-auto">
            @forelse($transactions as $transaction)
                <li class="flex items-center gap-2 hover:bg-primary-100 px-8">
                    <span class="p-2 rounded {{$transaction->amount < 0 ? 'bg-red-600' : 'bg-green-500'}} text-white">
                        @if($transaction->amount < 0)
                            <i data-lucide="rocket" class="size-4 rotate-180"></i>
                        @else
                            <i data-lucide="rocket" class="size-4"></i>
                        @endif
                    </span>
                    <a href="#" class="flex-1 flex items-end justify-between font-medium text-gray-700 py-3">
                        <span class="text-sm">
                            <span class="text-xs font-light block">{{$transaction->created_at->diffForHumans()}}</span>
                            {{$transaction->meta['description'] ?? 'New Transaction'}}
                        </span>
                        <span class="text-xs font-bold">{{money($transaction->amount)}}</span>
                    </a>
                </li>
            @empty
                <li class="py-8 flex flex-col gap-2 justify-center items-center">
                    <span class="p-2 bg-primary-100 rounded-full"><i data-lucide="history" class="size-8 text-primary-400"></i></span>
                    <p class="text-xs text-slate-400 text-center">No transactions yet</p>
                </li>
            @endforelse
        </ul>
        <div class="mt-4 px-8">
            {{$transactions->links()}}
        </div>
    </section>
</x-tenant::layouts.app>
