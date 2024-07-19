@props([
    'title' => null
])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ucfirst(config('tenant.app.name'))}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-800">
    <main class="max-w-xl mx-auto shadow h-screen overflow-y-auto bg-white relative">
        @if($title)
            <header class="py-4 px-4 flex items-center sticky top-0 bg-white">
                <a href="{{route('tenant.dashboard')}}" class="flex flex-shrink-0 justify-center items-center gap-2 size-[46px] text-sm font-semibold rounded-lg border border-transparent disabled:opacity-50 disabled:pointer-events-none">
                    <x-bi-arrow-left class="size-4"/>
                </a>
                <h3 class="font-medium flex-1 text-center">{{$title}}</h3>
            </header>
        @endif
        <div class="absolute top-4 right-2">
            <x-template::alert :message="session('message')" status="success"/>
            <x-template::alert :message="session('error')" status="danger"/>
        </div>
        {{$slot}}
    </main>
</body>
</html>
