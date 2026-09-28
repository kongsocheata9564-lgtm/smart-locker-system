<header class="w-full border-b border-gray-200 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center h-16">

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
                <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
                </form>
            @endguest
        </nav>

        <!-- Mobile hamburger button -->
        <button
            type="button"
            onclick="var m=document.getElementById('mobileMenu'); m.classList.toggle('hidden'); document.getElementById('iconOpen').classList.toggle('hidden'); document.getElementById('iconClose').classList.toggle('hidden'); this.setAttribute('aria-expanded', !m.classList.contains('hidden'));"
            class="sm:hidden inline-flex items-center justify-center w-10 h-10 ml-62 rounded-lg bg-[#eaf1fb] text-[#123a6b] flex-shrink-0"
            aria-label="Toggle menu"
            aria-expanded="false">
            <svg id="iconOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg id="iconClose" class="hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                <line x1="6" y1="6" x2="18" y2="18"/>
                <line x1="18" y1="6" x2="6" y2="18"/>
            </svg>
        </button>
    </div>

    <!-- Mobile menu panel -->
    <nav id="mobileMenu" class="hidden sm:hidden border-t  border-gray-200 bg-white px-4 py-3 flex-col gap-3 w-full box-border">
        @guest
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-medium text-center px-4 py-2 rounded-lg bg-[#123a6b] text-white hover:bg-[#0d2a52] no-underline">Register</a>
        @else
            <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#123a6b] no-underline py-2">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-sm font-medium px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Logout</button>
            </form>
        @endguest
    </nav>
</header>