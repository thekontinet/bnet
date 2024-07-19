<div class=" flex flex-col divide-y divide-gray-200 dark:divide-neutral-700">
    @forelse($transactions as $transaction)
        <button class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-gray-800 dark:text-white">
            <div class="flex items-center justify-between w-full">
                <div class="text-left">
                    <span class="font-medium">{{ucfirst($transaction->description)}}</span>
                    <span class="block text-slate-500 font-light text-xs">{{$transaction->created_at->diffForHumans()}}</span>
                </div>
                <span class="{{$transaction->type == 'deposit' ? 'text-green-600' : 'text-red-600'}}">{{money(abs($transaction->amount))}}</span>
            </div>
        </button>
    @empty
        <div class="py-12 text-slate-400">
            <p class="text-center text-sm">No Orders</p>
        </div>
    @endforelse

    @if(method_exists($transactions, 'links'))
        <div class="py-4">
            {{$transactions->links()}}
        </div>
    @endif
</div>
