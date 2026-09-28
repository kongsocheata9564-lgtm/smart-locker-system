<header class="w-full border-b border-gray-200 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-left h-16">

        <!-- Logo / Brand -->
        <img src="{{ asset('images/logo-smart.png') }}" alt="" class="w-15 h-11">
            <span class="leading-none truncate">
                <span class="block text-base font-extrabold tracking-tight text-[#123a6b] truncate">
                    SMART <span class="text-[#1e5fc4]">LOCKER</span>
                </span>
                <span class="block text-[8px] font-semibold tracking-[2px] text-gray-400">
                    S Y S T E M
                </span>
            </span>
        </a>

        <!-- Desktop nav links -->
        <nav class="hidden sm:flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline">Login</a>
                <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 rounded-lg bg-[#123a6b] text-white hover:bg-[#0d2a52] no-underline">Register</a>
            @else
                <a href="{{ route('user.index') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
                </form>
            @endguest
        </nav>
    </div>

    <!-- Mobile menu panel -->
    <nav id="mobileMenu" class="hidden sm:hidden border-t  border-gray-200 bg-white px-4 py-3 flex-col gap-3 w-full box-border">
        @guest
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-medium text-center px-4 py-2 rounded-lg bg-[#123a6b] text-white hover:bg-[#0d2a52] no-underline">Register</a>
        @else
            <a href="{{ route('user.index') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
            </form>
        @endguest
    </nav>
</header>