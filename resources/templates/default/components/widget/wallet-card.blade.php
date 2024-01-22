<div {{$attributes->merge(['class' => 'py-2 px-4 bg-blue-700 rounded flex justify-between items-center'])}}>
    <h5 class="uppercase font-medium text-xs">Total Balance</h5>
    <p class="font-light text-2xl">{{money($user->wallet->balance)}}</p>
</div>
