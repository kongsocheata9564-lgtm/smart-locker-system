@extends('layouts.guest')
@section('title', 'Smart Locker System')
@section('page_title', 'Welcome')
@section('content')
    <div class="max-w-2xl mx-auto mt-5 text-center">
       <section class="px-4 pt-2">
    <div class="relative overflow-hidden rounded-3xl min-h-[300px] flex flex-col justify-end px-5 pt-7 pb-6 text-white">

        <!-- Background -->
       <div class="absolute inset-0 z-0">
    <img
        src="{{ asset('images/image.png') }}"
        alt=""
        class="absolute inset-0 w-full h-full object-cover"
    >
    <div class="absolute inset-0 bg-gradient-to-b from-[#0d2a52]/60 via-[#0d2a52]/60 to-[#06142e]/90"></div>
</div>

        <!-- Content -->
        <div class="relative z-10">
            <h1 class="text-[30px] leading-[1.14] font-extrabold tracking-tight mb-2.5" style="text-shadow: 0 2px 10px rgba(0,0,0,.25);">
                Find &amp; Use<br>Lockers Easily
            </h1>
            <p class="text-[13.5px] text-white/85 font-medium mb-5">
                Safe, Convenient, Always Nearby
            </p>

            <form action="{{ route('staff.locations.index') }}" method="GET" class="bg-white rounded-2xl flex items-center gap-2.5 px-4 py-3.5 shadow-lg">
                <svg class="w-[18px] h-[18px] text-[#1e5fc4] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" placeholder="Search location (e.g. ABC Mall)"
                       class="flex-1 border-0 outline-none text-[13.5px] text-gray-900 placeholder-gray-400 bg-transparent">
                <button type="submit" aria-label="Search" class="w-6.5 h-6.5 rounded-full flex items-center justify-center text-[#1e5fc4] flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Category shortcuts -->
<section class="grid grid-cols-4 gap-2.5 px-5 pt-6 pb-1">
    <a href="{{ route('staff.locations.index', ['category' => 'shopping']) }}" class="flex flex-col items-center gap-2 text-center no-underline group">
        <span class="w-13 h-13 w-[52px] h-[52px] rounded-2xl bg-[#eaf1fb] flex items-center justify-center text-[#17488a] transition group-hover:bg-[#dbe8fb] group-hover:-translate-y-0.5">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
        </span>
        <span class="text-[11.5px] font-bold text-gray-900 leading-tight">Shopping<br>Areas</span>
    </a>

    <a href="{{ route('staff.locations.index', ['category' => 'libraries']) }}" class="flex flex-col items-center gap-2 text-center no-underline group">
        <span class="w-[52px] h-[52px] rounded-2xl bg-[#eaf1fb] flex items-center justify-center text-[#17488a] transition group-hover:bg-[#dbe8fb] group-hover:-translate-y-0.5">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
        </span>
        <span class="text-[11.5px] font-bold text-gray-900 leading-tight">Libraries</span>
    </a>

    <a href="{{ route('staff.locations.index', ['category' => 'buildings']) }}" class="flex flex-col items-center gap-2 text-center no-underline group">
        <span class="w-[52px] h-[52px] rounded-2xl bg-[#eaf1fb] flex items-center justify-center text-[#17488a] transition group-hover:bg-[#dbe8fb] group-hover:-translate-y-0.5">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="4" y="2" width="16" height="20" rx="1"/>
                <line x1="8" y1="6" x2="8" y2="6.01"/><line x1="12" y1="6" x2="12" y2="6.01"/><line x1="16" y1="6" x2="16" y2="6.01"/>
                <line x1="8" y1="10" x2="8" y2="10.01"/><line x1="12" y1="10" x2="12" y2="10.01"/><line x1="16" y1="10" x2="16" y2="10.01"/>
                <line x1="8" y1="14" x2="8" y2="14.01"/><line x1="12" y1="14" x2="12" y2="14.01"/><line x1="16" y1="14" x2="16" y2="14.01"/>
                <line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/>
            </svg>
        </span>
        <span class="text-[11.5px] font-bold text-gray-900 leading-tight">Buildings</span>
    </a>

    <a href="{{ route('staff.locations.index', ['category' => 'sports']) }}" class="flex flex-col items-center gap-2 text-center no-underline group">
        <span class="w-[52px] h-[52px] rounded-2xl bg-[#eaf1fb] flex items-center justify-center text-[#17488a] transition group-hover:bg-[#dbe8fb] group-hover:-translate-y-0.5">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                <path d="M2 12h20"/>
            </svg>
        </span>
        <span class="text-[11.5px] font-bold text-gray-900 leading-tight">Sports<br>Centers</span>
    </a>
</section>

<!-- CTA -->
<section class="px-5 pt-5 pb-7">
    <a href="{{ route('staff.locations.index') }}"
       class="w-full flex items-center justify-center gap-2.5 rounded-full px-6 py-4 text-white font-bold text-[15px] no-underline shadow-lg transition hover:-translate-y-0.5"
       style="background: linear-gradient(135deg, #123a6b, #0d2a52);">
        Get Started
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
        </svg>
    </a>
</section>
    </div>
@include('partials.guest-footer')
@yield('content')

@endsection