<x-tenant::layouts.app class="bg-white flex flex-col">
    <section class="bg-gradient-to-tl from-blue-500 to-blue-700 px-8 pt-6 pb-14 text-white grid gap-4">
        <x-tenant::welcome-header/>
        <x-tenant::widget.wallet-card :user="auth()->user()"/>
    </section>

    <section class="px-2 -mt-12 relative z-10 shadow bg-white rounded-xl py-4">
        <div class="flex items-center justify-between gap-4">
            <x-tenant::widget.menu-card :url="route('tenant.deposit')"
                                        label="Add Funds"
                                         icon="data-lucide=plus"/>

            <x-tenant::widget.menu-card :url="route('tenant.service.purchase', \App\Enums\ServiceEnum::AIRTIME)"
                                        label="Airtime"
                                        icon="data-lucide=smartphone"/>

            <x-tenant::widget.menu-card :url="route('tenant.service.purchase', \App\Enums\ServiceEnum::DATA)"
                                        label="Data"
                                        icon="data-lucide=wifi"/>

            <x-tenant::widget.menu-card :url="route('tenant.transaction.index')"
                                        label="Transactions"
                                        icon="data-lucide=newspaper"/>
        </div>
    </section>

    <section class="py-4 bg-white space-y-4 flex flex-col min-h-60">
        <ul class="space-y-2 h-full overflow-y-auto w-full">
            @forelse($transactions as $transaction)
                <li class="flex items-center gap-2 hover:bg-blue-100 px-8">
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
                        <span class="text-xs font-bold">{{money($transaction->amount)->absolute()}}</span>
                    </a>
                </li>
            @empty
                <li class="py-8 flex flex-col gap-2 justify-center items-center">
                    <span class="p-2 bg-blue-100 rounded-full"><i data-lucide="history" class="size-8 text-blue-400"></i></span>
                    <p class="text-xs text-slate-400 text-center">No transactions yet</p>
                </li>
            @endforelse
        </ul>
    </section>
</x-tenant::layouts.app>
