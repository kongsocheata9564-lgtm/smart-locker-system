<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        <!-- Logo / Brand (left) -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('images/logo-smart.png') }}" alt="Smart Locker System" class="h-11 w-auto object-contain">
            <span class="leading-none truncate">
                <span class="block text-base font-extrabold tracking-tight text-[#123a6b] truncate">
                    SMART <span class="text-[#1e5fc4]">LOCKER</span>
                </span>
                <span class="block text-[8px] font-semibold tracking-[2px] text-gray-400">
                    S Y S T E M
                </span>
            </span>
        </a>

        <!-- Desktop nav links (right) -->
        <nav class="hidden sm:flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline">Login</a>
                <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 rounded-lg bg-[#123a6b] text-white hover:bg-[#0d2a52] no-underline">Register</a>
            @else
                <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
                </form>
            @endguest
        </nav>

        <!-- Mobile menu button (right, phones only) -->
        <button type="button"
                class="sm:hidden text-gray-500 hover:text-gray-700"
                onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                aria-label="Menu">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <!-- Mobile menu panel -->
    <nav id="mobileMenu" class="hidden sm:hidden border-t border-gray-200 bg-white px-4 py-3 grid gap-3 w-full box-border">
        @guest
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-medium text-center px-4 py-2 rounded-lg bg-[#123a6b] text-white hover:bg-[#0d2a52] no-underline">Register</a>
        @else
            <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
            </form>
        @endguest
    </nav>
</header>