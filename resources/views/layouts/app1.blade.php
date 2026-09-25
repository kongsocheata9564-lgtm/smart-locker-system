<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tittle')</title>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

</head>
<body>
   
@php
    $isUserRoute = request()->routeIs('user.dashboard') 
        || request()->routeIs('locations.*') 
        || request()->routeIs('lockers.*') 
        || request()->routeIs('assignments.*') 
        || request()->routeIs('access-codes.*') 
        || request()->routeIs('usage-history.*') 
        || request()->routeIs('profile');

    $isStaffRoute = request()->routeIs('staff.dashboard') 
        || request()->routeIs('staff.users.*') 
        || request()->routeIs('staff.maintenance.*');

    $isAuthRoute = request()->routeIs('login') || request()->routeIs('register');
@endphp

@if(!$isAuthRoute)
<div class="flex min-h-screen">
    @if($isUserRoute)
        @include('user.partials.sidebar')
    @elseif($isStaffRoute)
        @include('.partials.sidebar')
    @else
        @include('partials.sidebar')
    @endif

    <main class="ml-[250px] flex-1 px-2 min-h-screen bg-gray-50">
        

        <div class="p-3">
            @yield('content')
        </div>
    </main>
</div>
@else
    <div class="min-h-screen bg-gray-50">
        @yield('content')
    </div>
@endif
</body>
</html>