<div>
    <div class="text-primary-800 flex border overflow-hidden bg-primary-200">
        <div class="bg-primary-500 text-white p-4 grid place-items-center"><span data-lucide="info" class="size-8"></span></div>
        <p class="flex-1 p-4">{{tenant()->settings()->get(\App\Enums\Config::BANK_PAYMENT_INFO->value)}}</p>
    </div>

    <ul class="mt-2 px-4">
        <li class="grid grid-cols-2 border-b py-4 px-2"><strong class="font-medium">Bank Name:</strong> <span>{{tenant()->settings()->get(\App\Enums\Config::BANK_NAME->value)}}</span></li>
        <li class="grid grid-cols-2 border-b py-4 px-2"><strong class="font-medium">Account Name:</strong> <span>{{tenant()->settings()->get(\App\Enums\Config::BANK_ACCOUNT_NAME->value)}}</span></li>
        <li class="grid grid-cols-2 border-b py-4 px-2"><strong class="font-medium">Account Number:</strong> <span>{{tenant()->settings()->get(\App\Enums\Config::BANK_ACCOUNT_NUMBER->value)}}</span></li>
    </ul>


    <a href="https://wa.me/{{tenant('phone')}}" class="block p-4"><x-tenant::secondary-button class="mt-4">Contact Admin</x-tenant::secondary-button></a>
</div>
