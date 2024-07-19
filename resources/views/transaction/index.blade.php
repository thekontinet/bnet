<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Transactions') }}
            </h2>

            <x-link href="{{route('dashboard')}}" target="_blank">
                {{__('Back')}}
            </x-link>
        </div>
    </x-slot>

    <!-- Table Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-10 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                          Invoice number
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                          Amount
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                          Status
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                          Created
                                        </span>
                                    </div>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @foreach($transactions as $transaction)
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">
                                        <td class="size-px whitespace-nowrap">
                                            <button type="button" class="block" data-hs-overlay="#hs-ai-invoice-modal">
                                            <span class="block px-6 py-2">
                                              <span class="font-mono text-sm text-blue-600 dark:text-blue-500">#{{str($transaction->id)->padLeft(6, 0)}}</span>
                                            </span>
                                            </button>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <button type="button" class="block" data-hs-overlay="#hs-ai-invoice-modal">
                                            <span class="block px-6 py-2">
                                              <span class="text-sm text-gray-600 dark:text-neutral-400">{{money(abs($transaction->amount))}}</span>
                                            </span>
                                            </button>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <button type="button" class="block" data-hs-overlay="#hs-ai-invoice-modal">
                                            <span class="block px-6 py-2">
                                              <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium {{$transaction->type === 'withdraw' ? 'bg-teal-100 text-red-800 dark:bg-red-500/10 dark:text-red-500' : 'bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500'}} rounded-full">
                                                {{ucfirst($transaction->description)}}
                                              </span>
                                            </span>
                                            </button>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <button type="button" class="block" data-hs-overlay="#hs-ai-invoice-modal">
                                            <span class="block px-6 py-2">
                                              <span class="text-sm text-gray-600 dark:text-neutral-400">{{$transaction->created_at->diffForHumans()}}</span>
                                            </span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->

    {{$transactions->links()}}
</x-app-layout>
