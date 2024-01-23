<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{tenant('brand_description')}}">
    <title>{{ucfirst(tenant('brand_name'))}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main {{$attributes->merge(['class' => "min-h-screen max-w-xl mx-auto border shadow relative"])}}>

    {{$slot}}

</main>
</body>
</html>
