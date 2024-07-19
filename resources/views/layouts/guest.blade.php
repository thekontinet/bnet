<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-neutral-900">
            <div class="mb-4">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                <x-dark-mode-switch hidden/>
            </div>

            <div class="w-full max-w-xl flex flex-col bg-white border shadow-sm rounded-xl dark:text-gray-200 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 p-4 md:p-5">
                <x-alert/>
                {{ $slot }}
            </div>
            <footer>{{$footer ?? null}}</footer>
        </div>
    </body>
</html>
