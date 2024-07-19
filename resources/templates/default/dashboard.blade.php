@php
$menuItems = [
    'dashboard' => [
        'icon' => 'bx-home-alt',
        'title' => 'Dashboard',
        'href' => route('tenant.dashboard'),
    ]
]
@endphp

<x-tenant::layouts.app class="bg-white flex flex-col">
{{--    <section class="bg-gradient-to-tl from-primary-500 to-primary-700 px-8 pt-6 pb-14 text-white grid gap-4">--}}
{{--        <x-tenant::welcome-header/>--}}
{{--        <x-tenant::widget.wallet-card :user="auth()->user()"/>--}}
{{--    </section>--}}
    <header class="p-4 flex items-center justify-between">
        <div>
            <h1>Hello {{$user->firstname}}</h1>
        </div>
        <div>
            <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10"  data-hs-overlay="#hs-overlay-right">
                <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </header>

    <div id="hs-overlay-right" class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white border-s dark:bg-neutral-800 dark:border-neutral-700" tabindex="-1">
        <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
            <h3 class="font-bold text-gray-800 dark:text-white">
                Profile Design
            </h3>
            <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#hs-overlay-right">
                <span class="sr-only">Close modal</span>
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <nav class="hs-accordion-group p-1 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="space-y-1.5">
                    <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-neutral-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-700 dark:text-white" href="#">
                            <x-bx-home-alt class="size-5"/>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                            Calendar
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

{{--    <section class="px-2 -mt-12 relative z-10 shadow bg-white rounded-xl py-4">--}}
{{--        <div class="flex items-center justify-between gap-4">--}}
{{--            <x-tenant::widget.menu-card :url="route('tenant.deposit')"--}}
{{--                                        label="Add Funds"--}}
{{--                                         icon="data-lucide=plus"/>--}}

{{--            <x-tenant::widget.menu-card :url="route('tenant.service.purchase', \App\Enums\ServiceEnum::AIRTIME)"--}}
{{--                                        label="Airtime"--}}
{{--                                        icon="data-lucide=smartphone"/>--}}

{{--            <x-tenant::widget.menu-card :url="route('tenant.service.purchase', \App\Enums\ServiceEnum::DATA)"--}}
{{--                                        label="Data"--}}
{{--                                        icon="data-lucide=wifi"/>--}}

{{--            <x-tenant::widget.menu-card :url="route('tenant.transaction.index')"--}}
{{--                                        label="Transactions"--}}
{{--                                        icon="data-lucide=newspaper"/>--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="py-4 bg-white space-y-4 flex flex-col min-h-60">
        <x-template::order.list :orders="$orders"/>
    </section>
</x-tenant::layouts.app>
