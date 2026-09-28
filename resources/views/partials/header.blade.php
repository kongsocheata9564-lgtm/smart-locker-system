<header class="sticky top-0 z-10 flex items-center justify-between bg-white border-b border-gray-100 mx-3 mt-2 px-4 py-3">

    <div class="flex items-center gap-3">
        <button type="button" class="text-gray-400 hover:text-gray-600 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-800">@yield('page_title')</h1>
    </div>

    <div class="flex items-center gap-4">
        <button type="button" class="text-gray-400 hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
        </button>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xs font-bold">
                SD
            </div>
            <div class="hidden sm:block text-left leading-tight">
                {{-- TODO: swap for auth()->user()->name / role once dynamic --}}
                <p class="text-sm font-medium text-gray-700">Somnang Dara</p>
                <p class="text-xs text-gray-400">User</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>

</header>