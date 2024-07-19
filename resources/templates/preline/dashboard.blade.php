@php
    $menuItems = [
//        'dashboard' => [
//            'icon' => 'bx-home-alt',
//            'title' => 'Dashboard',
//            'href' => route('tenant.dashboard'),
//            'active' => request()->routeIs('tenant.dashboard'),
//        ],
//        'services' => [
//            'icon' => 'bx-home-alt',
//            'title' => 'Services',
//            'href' => '#',
//            'active' => false,
//        ]
    ]
@endphp

<x-template::layouts.app>
    <header class="p-4 flex items-center justify-between">
        <div>
            <h1>Hello {{$user->firstname}}</h1>
        </div>
        <div>
            <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10"  data-hs-overlay="#side-menu-panel">
                <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </header>

    <section class="p-4">
        <div class="bg-primary-700 text-white p-4 rounded flex items-center justify-between">
            <div>
                <h4 class="text-sm">My Balance</h4>
                <p class="text-xl font-medium">{{money($user->wallet->balance)}}</p>
            </div>
            <button class="border border-primary-800 hover:bg-primary-900 bg-primary-800 inline-flex items-center justify-center rounded p-2" data-hs-overlay="#deposit-panel">
                <x-bx-wallet-alt class="size-6 text-primary-100"/>
                <span class="px-2">DEPOSIT</span>
            </button>
        </div>
    </section>

    <!-- Top Menu -->
    <section class="px-4 py-2 flex items-center justify-between">
        <a href="#" class="text-center items-center justify-center flex flex-col gap-1" title="Fund wallet" data-hs-overlay="#deposit-panel">
            <span class="inline-flex items-center justify-center p-3 rounded-full bg-primary-800 hover:bg-primary-700">
                <x-bx-wallet-alt class="size-6 text-white"/>
            </span>
            <span class="text-xs text-center">Fund Wallet</span>
        </a>

        <a href="{{route('tenant.airtime.create')}}" class="text-center items-center justify-center flex flex-col gap-1" title="Buy airtime">
            <span class="inline-flex items-center justify-center p-3 rounded-full bg-primary-800 hover:bg-primary-700">
                <x-bx-microphone class="size-6 text-white"/>
            </span>
            <span class="text-xs text-center">Buy Airtime</span>
        </a>

        <a href="{{route('tenant.data-plan.create')}}" class="text-center items-center justify-center flex flex-col gap-1" title="Data purchase">
            <span class="inline-flex items-center justify-center p-3 rounded-full bg-primary-800 hover:bg-primary-700">
                <x-bi-modem class="size-6 text-white"/>
            </span>
            <span class="text-xs text-center">Data Purchase</span>
        </a>

        <a href="{{route('tenant.transaction.index')}}" class="text-center items-center justify-center flex flex-col gap-1" title="Transactions">
            <span class="inline-flex items-center justify-center p-3 rounded-full bg-primary-800 hover:bg-primary-700">
                <x-bi-clock-history class="size-6 text-white"/>
            </span>
            <span class="text-xs text-center">Transactions</span>
        </a>
    </section>

    <hr class="mx-4 my-2">

    <!-- Order Summary -->
    <section class="px-4 py-2">
        <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200 py-4">Recent Transactions</h4>

        <div class="overflow-y-auto pb-24">
            @include('template::partials.transaction-list')
        </div>
    </section>

    <!-- Bottom Nav -->
    <footer class="flex fixed bottom-4 px-8 w-full max-w-xl">
        <div class="flex w-full bg-primary-50 hover:bg-gray-200 rounded-lg transition p-1 dark:bg-neutral-700 dark:hover:bg-neutral-600">
            <nav class="flex justify-between items-center w-full space-x-2">
{{--                <a class="py-3 px-4 inline-flex flex-col items-center bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-primary-600 dark:text-neutral-400 dark:hover:text-white" href="#">--}}
{{--                    <x-bx-globe-alt class="size-5 text-primary-600" />--}}
{{--                    <span class="text-[0.56rem] -mt-1">Services</span>--}}
{{--                </a>--}}

                <a class="py-3 px-4 inline-flex flex-col items-center bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-primary-600 dark:text-neutral-400 dark:hover:text-white" href="{{route('tenant.orders.index')}}">
                    <x-bi-arrow-repeat class="size-5 text-primary-600" />
                    <span class="text-[0.56rem] -mt-1">Orders</span>
                </a>

                <a class="py-3 px-4 inline-flex flex-col items-center bg-primary-500 text-sm text-gray-700 font-medium rounded-lg shadow-lg border dark:bg-neutral-800 dark:text-neutral-400" href="#" aria-current="page">
                    <x-bx-home-alt class="size-5 text-primary-200 my-2" />
                </a>

                <a class="py-3 px-4 inline-flex flex-col items-center bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-primary-600 dark:text-neutral-400 dark:hover:text-white" href="{{route('tenant.setting.index')}}">
                    <x-bx-cog class="size-5 text-primary-600" />
                    <span class="text-[0.56rem] -mt-1">Settings</span>
                </a>
            </nav>
        </div>
    </footer>


    <!-- Right Menu Panel -->
    <x-template::overlays.drawer name="side-menu-panel" position="left">
        <div class="p-4 flex flex-col">
            <nav class="hs-accordion-group p-1 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="space-y-1.5">
                    @foreach($menuItems as $menuItem)
                        <x-template::menu.menu-item :title="$menuItem['title']" :icon="$menuItem['icon']" :href="$menuItem['href']" :active="$menuItem['active']"/>
                    @endforeach
                </ul>
            </nav>
            <form action="{{route('tenant.logout')}}" method="post" class="mt-auto">
                <x-primary-button class="w-full gap-6">
                    <x-bx-log-out class="size-5"/>
                    <span>Log Out</span>
                </x-primary-button>
            </form>
        </div>
    </x-template::overlays.drawer>

    <!-- Deposit Panel -->
    <x-template::overlays.drawer class="max-w-xl mx-auto min-h-svh px-8" name="deposit-panel" position="bottom" active="{{$errors->has('amount')}}">
        <x-slot name="header">
            <h3 class="font-medium text-gray-800 dark:text-white flex-1 text-center">Wallet Deposit</h3>
        </x-slot>
        @include('template::partials.deposit-form')
    </x-template::overlays.drawer>
</x-template::layouts.app>
