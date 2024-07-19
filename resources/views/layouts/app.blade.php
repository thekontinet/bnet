@php
    $navitems = [
        'Dashboard' => [
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'bi-house'
        ],

        'Customers' => [
            'href' => route('customer.index'),
            'active' => request()->routeIs('customer.index'),
            'icon' => 'bi-people'
        ],
        'Orders' => [
            'href' => route('order.index'),
            'active' => request()->routeIs('order.index'),
            'icon' => 'bi-receipt'
        ],
        'Transactions' => [
            'href' => route('transaction.index'),
            'active' => request()->routeIs('transaction.index'),
            'icon' => 'bi-arrow-repeat'
        ],
        'Pricing Configuration' => [
            'href' => route('services.index'),
            'active' => request()->routeIs('services.*'),
            'icon' => 'bi-hdd'
        ],
    ];

    $dropitems = [
        'Account Settings' => [
            'href' => route('profile.edit'),
            'active' => request()->routeIs('profile.edit'),
        ],
        'Business Settings' => [
            'href' => route('business'),
            'active' => request()->routeIs('site'),
        ],
        'Payment Settings' => [
            'href' => route('settings.edit', 'payment'),
            'active' => request()->routeIs('settings.edit', 'payment'),
        ]
    ]
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:text-gray-200 dark:bg-neutral-900">
        <section class="flex h-full">
            <div class="hidden md:block fixed z-50 inset-y-0">
                @include('layouts.sidebar')
            </div>
            <div class="min-h-screen flex-1 md:pl-20">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @if (isset($header))
                    <header>
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="pb-24">
                    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 flex justify-end">
                        <x-alert/>
                    </div>
                    {{ $slot }}
                </main>
                <footer class="md:hidden fixed z-50 inset-x-0 bottom-0">
                    @include('layouts.bottom-nav')
                </footer>
            </div>
        </section>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
