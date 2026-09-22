<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 grid grid-cols-4 z-40"
     style="padding-bottom: env(safe-area-inset-bottom, 0px);">

    <a href="{{ route('home') }}"
       class="flex flex-col items-center justify-center gap-1 py-2.5 no-underline {{ request()->routeIs('user.dashboard') ? 'text-[#123a6b]' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M3 9.5 12 3l9 6.5"/>
            <path d="M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10"/>
        </svg>
        <span class="text-[11px] font-semibold">Home</span>
    </a>

    <a href="{{ route('location') }}"
       class="flex flex-col items-center justify-center gap-1 py-2.5 no-underline {{ request()->routeIs('user.locations.*') ? 'text-[#123a6b]' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        <span class="text-[11px] font-semibold">Locations</span>
    </a>

    <a href="{{ route('activity') }}"
       class="flex flex-col items-center justify-center gap-1 py-2.5 no-underline {{ request()->routeIs('user.usage-history.*') ? 'text-[#123a6b]' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M9 11l3 3L22 4"/>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        <span class="text-[11px] font-semibold">Activity</span>
    </a>

    <a href="{{ route('profile') }}"
       class="flex flex-col items-center justify-center gap-1 py-2.5 no-underline {{ request()->routeIs('user.profile') ? 'text-[#123a6b]' : 'text-gray-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21c1.5-4 5-6 8-6s6.5 2 8 6"/>
        </svg>
        <span class="text-[11px] font-semibold">Profile</span>
    </a>
</nav>