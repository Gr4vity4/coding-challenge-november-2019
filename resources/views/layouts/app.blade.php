<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coding Challenge November 2019</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container max-w-7xl mx-auto">
        <div class="flex flex-col h-screen">
            <div class="w-full bg-gray-100 p-6 font-bold">Coding Challenge November 2019</div>
            <div class="grow border p-6">@yield('content')</div>
            <div class="w-full bg-gray-100 p-6 text-center text-gray-400">Copyright &copy; {{ now()->format('Y') }}</div>
        </div>
    </div>
    @yield('scripts')
</body>

</html>