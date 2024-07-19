<div {{$attributes->merge(['class' => 'py-2 px-4 bg-primary-700 rounded flex justify-between items-center'])}}>
    <h5 class="uppercase font-medium text-xs">Total Balance</h5>
    <p class="font-bold text-sm">{{money($user->wallet->balance)}}</p>
</div>
