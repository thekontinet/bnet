<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--TODO: add all required meta tags--}}
    <meta name="description" content="{{tenant('brand_description')}}">
    <title>{{ucfirst(tenant('brand_name'))}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-full items-center dark:bg-neutral-800">
<main {{$attributes->merge(['class' => "w-full max-w-xl mx-auto p-6 h-screen flex items-center"])}}>
    <div class="w-full bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
        <div class="p-4">
            {{$slot}}
            <x-dark-mode-switch class="dark:bg-gray-700 bg-gray-100 grid place-items-center fixed right-8 bottom-8 size-12 p-4 rounded-full shadow"/>
        </div>
    </div>
</main>
</body>
</html>
