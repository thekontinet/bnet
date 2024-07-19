@props(['orders'])
<ul class="space-y-2 h-full overflow-y-auto">
    @forelse($orders as $order)
        <x-template::order.item :order="$order"/>
    @empty
        <li class="py-8 flex flex-col gap-2 justify-center items-center">
            <span class="p-2 bg-primary-100 rounded-full"><i data-lucide="history" class="size-8 text-primary-400"></i></span>
            <p class="text-xs text-slate-400 text-center">No transactions yet</p>
        </li>
    @endforelse
</ul>
