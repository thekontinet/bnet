<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{tenant('username')}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main {{$attributes->merge(['class' => "flex flex-col h-screen max-w-xl mx-auto border shadow relative bg-slate-100"])}}>
    <x-tenant::alert/>
    {{$slot}}
</main>
<footer class="fixed inset-x-0 bottom-0">
    <x-tenant::layouts.bottom-navigation/>
</footer>
</body>
</html>
