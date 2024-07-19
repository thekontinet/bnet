@props(['customer'])
@php
$bag = $customer->email
@endphp
<div class="max-w-sm border dark:border-neutral-800 p-4 rounded bg-slate-100 dark:bg-neutral-800">
    <h4 class="font-medium text-lg">{{str($customer->firstname)->append(' ', $customer->lastname)}}</h4>
    <p class="text-sm">{{$customer->email}}</p>
    <p class="text-sm">{{$customer->created_at->format('jS M Y')}}</p>
    <p class="text-sm font-medium">Balance: {{money($customer->wallet->balance)}}</p>
    <div class="flex items-center flex-col  gap-2 mt-4">
        <x-primary-button class="w-full justify-between gap-2" x-data x-on:click.prevent="$dispatch('open-modal', 'modal-{{$customer->id}}')">
            Manage Balance
            <span data-lucide="wallet" class="size-4"></span>
        </x-primary-button>
        <a class="w-full" href="https://wa.me/{{$customer->phone}}">
            <x-secondary-button class="w-full justify-between">
                Contact on Whatsapp
                <span data-lucide="message-square" class="size-4"></span>
            </x-secondary-button>
        </a>
    </div>



    <!-- Deposit Modal Box -->
    <x-modal :show="$errors->$bag->count()" name="modal-{{$customer->id}}">
        <header class="py-2 px-3">
            <h4 class="text-lg font-medium">Fund Customer Balance</h4>
        </header>
        <form class="p-3" action="{{route('customer.update', $customer)}}" method="post" onsubmit="return confirm('Are you sure you want to perform this transaction ?')">
            @csrf
            <div>
                <x-input-label for="type" value="{{__('Customer')}}"/>
                <x-text-input class="w-full" value="{{$customer->fullname}}" :disabled="true"/>
            </div>

            <div class="mt-4">
                <x-input-label for="type" value="{{__('Type')}}"/>
                <x-select-input name="type" class="w-full">
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                </x-select-input>
                <x-input-error :messages="$errors->$bag->get('type')"/>
            </div>

            <div class="mt-4">
                <x-input-label for="amount" value="{{__('Amount')}}"/>
                <x-money-input id="amount" name="amount" class="w-full" placeholder="0.00" :value="old('amount')"/>
                <x-input-error :messages="$errors->$bag->get('amount')"/>
            </div>

            <div class="mt-4">
                <x-input-label for="description" value="{{__('Description')}}"/>
                <x-text-input id="description" name="description" class="w-full" placeholder="Write a short description" :value="old('description')"/>
                <x-input-error :messages="$errors->$bag->get('description')"/>
            </div>

            <div class="mt-4 flex gap-2 items-center">
                <x-primary-button>Fund Wallet</x-primary-button>
                <x-secondary-button type="button" x-data x-on:click.prevent="$dispatch('close-modal', 'modal-{{$customer->id}}')">Cancel</x-secondary-button>
            </div>
        </form>
    </x-modal>
</div>
