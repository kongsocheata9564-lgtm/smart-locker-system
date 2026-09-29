@php
    $authUser = auth()->user();

    $initials = collect(explode(' ', trim($authUser->name)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))
        ->implode('');

    $profileUrl = $authUser->isStaff()
        ? route('staff.profile')
        : route('user.profile');
@endphp
<header class="sticky top-0 z-10 flex items-center justify-between bg-white border-b border-gray-100 mx-3 mt-2 px-4 py-3">

    <div class="flex items-center gap-3">
        <button type="button" class="text-gray-400 hover:text-gray-600 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-800">@yield('page_title')</h1>
    </div>

   <a href="{{ $profileUrl }}" class="flex items-center gap-2 no-underline">
    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xs font-bold">
        {{ $initials }}
    </div>
    <div class="hidden sm:block text-left leading-tight">
        <p class="text-sm font-medium text-gray-700">{{ $authUser->name }}</p>
        <p class="text-xs text-gray-400">{{ ucfirst($authUser->role) }}</p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>
</a>

</header>