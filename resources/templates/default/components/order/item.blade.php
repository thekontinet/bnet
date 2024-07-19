@props(['order'])

<li class="flex items-center gap-2 hover:bg-primary-100 px-8">
    <span class="p-2 rounded bg-primary-900 text-white">
        <i data-lucide="package" class="size-4"></i>
    </span>
    <a href="#" class="flex-1 flex items-end justify-between font-medium text-gray-700 py-3">
        <span class="text-sm flex-1">
            {{$order->item->title ?? 'New Transaction'}}
            <span class="text-xs font-light block {{($order->status->getTextColor())}}">{{ucfirst($order->status->value)}}</span>
        </span>
        <span>
            <span class="text-xs font-bold mr-1">{{money($order->total)}}</span>
            <span class="text-xs block">{{$order->created_at->diffForHumans()}}</span>
        </span>
    </a>
</li>
