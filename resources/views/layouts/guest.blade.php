<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    @vite('resources/css/app.css')
</head>
<body>
    @yield('content')
</body>
</html>