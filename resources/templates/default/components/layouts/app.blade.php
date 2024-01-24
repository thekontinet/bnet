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
    <header>
        <x-tenant::alert/>
    </header>
    <div class="flex-1 overflow-y-auto">
        {{$slot}}
    </div>
   <footer class="">
       <x-tenant::layouts.bottom-navigation/>
   </footer>
</main>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
</body>
</html>
