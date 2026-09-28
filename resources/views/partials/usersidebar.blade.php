<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title></title>
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
                    class="w-28 h-27 object-contain">
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-2"></div>

        <!-- Nav -->
        <nav class="flex-1 flex flex-col gap-0.5 py-2 overflow-y-auto">

            <!-- Home -->
            <a href="{{ route('user.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('home') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                </svg>
                Dashboard
            </a>

            <!-- Locations -->
            <a href="{{ route('user.location.user') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('location.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Locations
            </a>

            <!-- Lockers -->
            <a href="{{ route('user.lockers.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('lockers.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                Lockers
            </a>



            <!-- Usage History -->
            <a href="{{ route('user.usage-history.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition {{ request()->routeIs('usage-history.*') ? 'active-nav' : '' }}">
                <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Usage History
            </a>

        </nav>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-2"></div>

        <!-- Profile + Logout -->
        <div class="px-2 py-2">
            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 mb-2 no-underline">
                <div class="flex items-center gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="w-6 h-6 text-gray-600">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 16.1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1.1 1.6v.1h-2.5v-.1a1.7 1.7 0 0 0-1.1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1-1.8-1.8.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1.1H6.2v-2.5h.1a1.7 1.7 0 0 0 1.6-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1 1.8-1.8.1.1a1.7 1.7 0 0 0 1.9.3 1.7 1.7 0 0 0 1.1-1.6V5h2.5v.1a1.7 1.7 0 0 0 1.1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1 1.8 1.8-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1.1h.1v2.5h-.1a1.7 1.7 0 0 0-1.6 1.3Z" />
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