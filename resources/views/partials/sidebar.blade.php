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

            <!-- Home -->
            <a href="{{ route('home') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('home') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                </svg>
                Dashboard
            </a>

            <!-- Locations -->
            <a href="{{ route('locations.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('locations.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Locations
            </a>

            <!-- Lockers -->
            <a href="{{ route('lockers.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('lockers.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                Lockers
            </a>


            
            <!-- Usage History -->
            <a href="{{ route('usage-history.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('usage-history.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Usage History
            </a>

            <!-- Maintenance -->
            <a href="{{ route('maintenance.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('maintenance.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
        d="M14.7 6.3a4.5 4.5 0 0 0-6.1 6.1L3.9 17.1a2.1 2.1 0 1 0 3 3l4.7-4.7a4.5 4.5 0 0 0 6.1-6.1l-2.6 2.6-2.8-2.8 2.4-2.8z" />
</svg>
                Maintenance
            </a>

            <!-- Staff Dashboard -->
            <a href="{{ route('staff.dashboard') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('staff.dashboard') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                Staff Dashboard
            </a>

            <!-- Users -->
            <a href="{{ route('users.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('users.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Users
            </a>

        </nav>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-2"></div>

        <!-- Profile + Logout -->
        <div class="px-2 py-2">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 mb-2 no-underline">
                <div class="flex items-center gap-3">
    <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    class="w-6 h-6 text-gray-600"
>
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M13.5 16.1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"
    />
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1.1 1.6v.1h-2.5v-.1a1.7 1.7 0 0 0-1.1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1-1.8-1.8.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1.1H6.2v-2.5h.1a1.7 1.7 0 0 0 1.6-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1 1.8-1.8.1.1a1.7 1.7 0 0 0 1.9.3 1.7 1.7 0 0 0 1.1-1.6V5h2.5v.1a1.7 1.7 0 0 0 1.1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1 1.8 1.8-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1.1h.1v2.5h-.1a1.7 1.7 0 0 0-1.6 1.3Z"
    />
</svg>

    <div class="overflow-hidden">
        <p class="text-sm font-semibold text-gray-800 truncate">Settings</p>
        <p class="text-xs text-gray-400 truncate">Manage your account</p>
    </div>
</div>
            </a>
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