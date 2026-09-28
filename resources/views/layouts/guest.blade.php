<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Locker System')</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    @include('partials.guest-header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.guest-footer')

</body>
</html>