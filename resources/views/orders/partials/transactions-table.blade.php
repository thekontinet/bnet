<div class="flex flex-col mt-6">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <span>Ref</span>
                        </th>

                        <th scope="col"
                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            Amount
                        </th>

                        <th scope="col"
                            class="px-4 py-3.5 text-right text-sm font-normal rtl:text-right text-gray-500 dark:text-gray-400">
                            <span>Date/Time</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                {{$transaction->reference}}
                            </td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                {{money($transaction->amount)}}
                            </td>
                            <td class="px-4 py-4 text-right text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                {{$transaction->created_at->format('jS M Y h:i:s a')}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

