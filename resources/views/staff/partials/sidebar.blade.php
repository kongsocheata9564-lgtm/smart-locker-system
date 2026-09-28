<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sidebar</title>
    <style>
        .nav-item {
            color: #111827;
        }

        .nav-item:hover {
            background-color: #eff6ff;
            color: #0051ff;
        }

        .nav-item.active-nav {
            background-color: #dbeafe;
            color: #003ec5;
        }
    </style>
</head>

<body>

    <div class="w-[250px] h-screen fixed top-0 left-0 bg-white border-r border-gray-100 shadow-sm flex flex-col p-3">

        <!-- Logo -->
       <div class="flex items-center">
    <!-- Logo -->
<div class="flex flex-col items-center justify-center mx-auto mb-2.5 gap-2 ">
    <img 
        src="{{ asset('images/logo-smart.png') }}" 
        alt="Smart Locker Logo"
        class="w-28 h-27 object-contain"
    >
</div>
</div>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-2"></div>

        <!-- Nav -->
        <nav class="flex-1 flex flex-col gap-0.5 py-2 overflow-y-auto">

            <!-- MAIN -->
            <div class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">MAIN</div>

            <!-- Dashboard -->
            <a href="{{ route('user.dashboard') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('user.dashboard') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                </svg>
                Dashboard
            </a>

            <!-- LOCKER -->
            <div class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-4">LOCKER</div>

            <!-- Find Locations -->
            <a href="{{ route('locations.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('locations.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Find Locations
            </a>

            <!-- My Locker -->
            <a href="{{ route('lockers.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('lockers.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                My Locker
            </a>

            <!-- My Assignments -->
            <a href="{{ route('assignments.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('assignments.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12z" />
                </svg>
                My Assignments
            </a>

            <!-- Access Code -->
            <a href="{{ route('access-codes.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('access-codes.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 6.75 21h6.75a2.25 2.25 0 0 0 2.25-2.25V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Access Code
            </a>

            <!-- Usage History -->
            <a href="{{ route('usage-history.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('usage-history.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Usage History
            </a>

            <!-- ACCOUNT -->
            <div class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-4">ACCOUNT</div>

            <!-- Profile -->
            <a href="{{ route('profile') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('profile') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Profile
            </a>

        </nav>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-2"></div>

        <!-- Logout -->
        <div class="px-2 py-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1 w-full px-2 py-2 mt-1 text-sm text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-150">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

</body>

</html>