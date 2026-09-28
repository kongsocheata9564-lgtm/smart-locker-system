@extends('layouts.guest')
@section('title', 'Smart Locker System')
@section('page_title', 'Welcome')
@section('content')

{{-- ============================================================
     DATA: $popular, $categoryCounts, $lockerCount and $locationCount
     come from the database (see the "/" route in routes/web.php)
     ============================================================ --}}
@php
    // Inner container: keeps text readable but lets backgrounds go FULL SCREEN.
    $wrap = 'w-full max-w-[1600px] mx-auto px-5 sm:px-8 lg:px-12';

    // Category cards. 'db' = the exact category name stored in the locations table.
    $categories = [
        ['label' => 'Shopping Areas', 'slug' => 'shopping',  'db' => 'Shopping Mall',
         'icon' => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>'],
        ['label' => 'Libraries',      'slug' => 'libraries', 'db' => 'Library',
         'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
        ['label' => 'Buildings',      'slug' => 'buildings', 'db' => 'Building',
         'icon' => '<rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/><line x1="8" y1="6" x2="8" y2="6.01"/><line x1="12" y1="6" x2="12" y2="6.01"/><line x1="16" y1="6" x2="16" y2="6.01"/><line x1="8" y1="10" x2="8" y2="10.01"/><line x1="12" y1="10" x2="12" y2="10.01"/><line x1="16" y1="10" x2="16" y2="10.01"/>'],
        ['label' => 'Sports Centers', 'slug' => 'sports',    'db' => 'Sports Center',
         'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/>'],
    ];

    // Card gradient per category (used when a location has no photo)
    $palette = [
        'Shopping Mall' => ['#1e5fc4', '#0d2a52'],
        'Library'       => ['#be185d', '#4a044e'],
        'Sports Center' => ['#e07a1f', '#7a2a0c'],
        'Building'      => ['#6d4bd8', '#1b1a55'],
    ];

    // Turn database rows into the array shape the cards use
    $popular = collect($popular)->map(function ($l) use ($palette) {
        $colors = $palette[$l->category] ?? ['#1e5fc4', '#0d2a52'];

        $tag = null;
        if ($l->free_lockers <= 5) {
            $tag = 'Almost full';
        } elseif ($l->rating && $l->rating >= 4.8) {
            $tag = 'Top rated';
        }

        return [
            'name'   => $l->name,
            'slug'   => $l->slug,
            'area'   => $l->category,
            'price'  => number_format($l->price_per_hour, 2),
            'free'   => $l->free_lockers,
            'rating' => $l->rating ? number_format($l->rating, 1) : null,
            'image'  => $l->image,
            'from'   => $colors[0],
            'to'     => $colors[1],
            'tag'    => $tag,
        ];
    })->values()->all();

    // Locker sizes (static prices for now: there is no price column per size yet)
    $sizes = [
        ['name' => 'Small',  'desc' => 'Bag, laptop, small items', 'price' => '0.30', 'h' => 'h-10'],
        ['name' => 'Medium', 'desc' => 'Backpack, shopping bags',  'price' => '0.50', 'h' => 'h-14', 'best' => true],
        ['name' => 'Large',  'desc' => 'Luggage, sports gear',     'price' => '0.80', 'h' => 'h-20'],
    ];
@endphp

{{-- Whole page wrapper: full width + light gray background --}}
<div class="w-full bg-gray-50 text-left">

    {{-- ============================================================
         1. ANNOUNCEMENT BAR
         ============================================================ --}}
    <div class="w-full bg-[#06142e] text-white text-center text-[12px] sm:text-[13px] font-medium py-2.5 px-4">
        New: book a locker in under 1 minute &middot; No account needed to browse
    </div>

    {{-- ============================================================
         2. HERO
         ============================================================ --}}
    <section class="relative w-full overflow-hidden text-white min-h-[560px] lg:min-h-[calc(100vh-120px)] flex items-center">

        {{-- Background image + dark blue gradient overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/image.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#06142e]/95 via-[#0d2a52]/80 to-[#0d2a52]/40"></div>
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>

        <div class="{{ $wrap }} relative z-10 py-14 pb-28 grid lg:grid-cols-2 gap-10 items-center">

            {{-- LEFT: text + search --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur px-3.5 py-1.5 rounded-full text-[12px] font-semibold mb-5">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span> Lockers available now
                </span>

                <h1 class="text-[40px] sm:text-[56px] lg:text-[68px] leading-[1.05] font-extrabold tracking-tight mb-4" style="text-shadow: 0 2px 12px rgba(0,0,0,.3);">
                    Find &amp; Use<br>Lockers Easily
                </h1>
                <p class="text-[15px] sm:text-[18px] text-white/85 font-medium mb-8 max-w-lg">
                    Safe, convenient, always nearby. Pick a place, choose a size, done.
                </p>

                {{-- Search bar (goes to the public locations page) --}}
                <form action="{{ route('location') }}" method="GET"
                      class="bg-white rounded-2xl flex items-center gap-2 p-2 pl-5 shadow-2xl max-w-xl">
                    <svg class="w-5 h-5 text-[#1e5fc4] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search location (e.g. ABC Mall)"
                           class="flex-1 min-w-0 border-0 outline-none focus:ring-0 text-[14px] sm:text-[15px] text-gray-900 placeholder-gray-400 bg-transparent">
                    <button type="submit"
                            class="bg-[#1e5fc4] hover:bg-[#17488a] transition text-white text-[14px] font-bold rounded-xl px-6 py-3">
                        Search
                    </button>
                </form>

                {{-- Quick search chips --}}
                <div class="flex flex-wrap gap-2 mt-5">
                    @foreach (['Shopping', 'Libraries', 'Buildings', 'Sports'] as $chip)
                        <a href="{{ route('location', ['category' => strtolower($chip)]) }}"
                           class="text-[12.5px] font-semibold bg-white/15 hover:bg-white/25 backdrop-blur rounded-full px-4 py-2 no-underline text-white transition">
                            {{ $chip }}
                        </a>
                    @endforeach
                </div>

                {{-- Stats row (real numbers) --}}
                <div class="flex gap-8 sm:gap-12 mt-9">
                    @foreach ([[number_format($lockerCount), 'Lockers'], [number_format($locationCount), 'Locations'], ['24/7', 'Access']] as $st)
                        <div>
                            <p class="text-[26px] sm:text-[32px] font-extrabold leading-none">{{ $st[0] }}</p>
                            <p class="text-[12px] text-white/70 mt-1">{{ $st[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT (desktop only): floating "live availability" card --}}
            <div class="hidden lg:block">
                <div class="ml-auto max-w-md bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[15px] font-bold">Live availability</p>
                        <span class="text-[11px] font-semibold bg-green-500/90 rounded-full px-2.5 py-1">Updated now</span>
                    </div>

                    <div class="space-y-3">
                        @forelse (array_slice($popular, 0, 4) as $p)
                            <a href="{{ route('location.show', $p['slug']) }}"
                               class="flex items-center gap-3 bg-white/10 hover:bg-white/20 transition rounded-2xl p-3 no-underline text-white">
                                <span class="w-11 h-11 rounded-xl flex-shrink-0" style="background: linear-gradient(135deg, {{ $p['from'] }}, {{ $p['to'] }});"></span>
                                <span class="flex-1 min-w-0">
                                    <span class="block text-[14px] font-bold leading-tight truncate">{{ $p['name'] }}</span>
                                    <span class="block text-[12px] text-white/70">{{ $p['area'] }}</span>
                                </span>
                                <span class="text-right">
                                    <span class="block text-[14px] font-extrabold">{{ $p['free'] }}</span>
                                    <span class="block text-[10.5px] text-white/70">free</span>
                                </span>
                            </a>
                        @empty
                            <p class="text-[13px] text-white/70">No locations yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         3. TRUST STRIP
         ============================================================ --}}
    <section class="{{ $wrap }} -mt-12 relative z-20">
        <div class="bg-white rounded-3xl shadow-xl grid grid-cols-2 lg:grid-cols-4 lg:divide-x divide-gray-100">
            @foreach ([
                ['Secure',          'Monitored 24/7',    'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                ['Instant Booking', 'Reserve in seconds','M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
                ['Always Nearby',   'Lots of locations', 'M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z'],
                ['Easy Payment',    'Pay by the hour',   'M2 7h20v12H2z M2 11h20'],
            ] as $t)
                <div class="flex items-center gap-4 px-5 py-5 sm:px-7 sm:py-6">
                    <span class="w-12 h-12 rounded-2xl bg-[#eaf1fb] text-[#17488a] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $t[2] }}"/></svg>
                    </span>
                    <div>
                        <p class="text-[14px] font-bold text-gray-900 leading-tight">{{ $t[0] }}</p>
                        <p class="text-[12px] text-gray-500 leading-tight mt-1">{{ $t[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================================================
         4. BROWSE BY CATEGORY
         ============================================================ --}}
    <section class="w-full pt-16 pb-4">
        <div class="{{ $wrap }}">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-[#1e5fc4]">Categories</p>
                    <h2 class="text-[24px] sm:text-[32px] font-extrabold text-gray-900 leading-tight">Browse by Category</h2>
                </div>
                <a href="{{ route('location') }}" class="text-[14px] font-bold text-[#1e5fc4] no-underline hover:underline">See all &rarr;</a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach ($categories as $cat)
                    @php $n = $categoryCounts[$cat['db']] ?? 0; @endphp
                    <a href="{{ route('location', ['category' => $cat['slug']]) }}"
                       class="group bg-white border border-gray-100 rounded-3xl p-5 sm:p-7 shadow-sm no-underline transition hover:shadow-xl hover:-translate-y-1.5">
                        <span class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-[#eaf1fb] group-hover:bg-[#1e5fc4] text-[#17488a] group-hover:text-white flex items-center justify-center transition mb-5">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                {!! $cat['icon'] !!}
                            </svg>
                        </span>
                        <p class="text-[16px] sm:text-[18px] font-bold text-gray-900 leading-tight">{{ $cat['label'] }}</p>
                        <p class="text-[12.5px] text-gray-500 mt-1">{{ $n }} {{ $n === 1 ? 'place' : 'places' }}</p>
                        <p class="text-[13px] font-bold text-[#1e5fc4] mt-4 opacity-0 group-hover:opacity-100 transition">Explore &rarr;</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         5. POPULAR LOCATIONS (top rated, up to 8)
         ============================================================ --}}
    <section class="w-full bg-white mt-14 py-16">
        <div class="{{ $wrap }}">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-[#1e5fc4]">Top picks</p>
                    <h2 class="text-[24px] sm:text-[32px] font-extrabold text-gray-900 leading-tight">Popular Locations</h2>
                </div>
                <a href="{{ route('location') }}" class="text-[14px] font-bold text-[#1e5fc4] no-underline hover:underline">View all &rarr;</a>
            </div>

            @if (count($popular) === 0)
                <p class="text-center text-gray-500 py-10">No locations yet. Please check back soon.</p>
            @endif

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($popular as $p)
                    <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm transition hover:shadow-2xl hover:-translate-y-1.5">

                        {{-- Image area: uploaded photo if there is one, otherwise a gradient --}}
                        <div class="relative h-32 sm:h-48 flex items-center justify-center"
                             style="background: linear-gradient(135deg, {{ $p['from'] }}, {{ $p['to'] }});">
                            @if ($p['image'])
                                <img src="{{ asset('storage/' . $p['image']) }}" alt="{{ $p['name'] }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <svg class="w-14 h-14 sm:w-20 sm:h-20 text-white/25 transition group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/>
                                    <rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/>
                                </svg>
                            @endif

                            {{-- Tag badge --}}
                            @if ($p['tag'])
                                <span class="absolute top-3 left-3 bg-white text-[#0d2a52] text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                    {{ $p['tag'] }}
                                </span>
                            @endif

                            {{-- Heart button --}}
                            <button type="button" aria-label="Save"
                                    class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 hover:bg-white flex items-center justify-center text-gray-600 hover:text-red-500 transition">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1.1L12 21l7.8-7.5 1-1.1a5.5 5.5 0 0 0 0-7.8z"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Card body --}}
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-[12px] text-gray-500 font-medium">{{ $p['area'] }}</p>
                                @if ($p['rating'])
                                    <p class="text-[12.5px] font-bold text-gray-800 flex items-center gap-1">
                                        <span class="text-amber-400">&#9733;</span>{{ $p['rating'] }}
                                    </p>
                                @endif
                            </div>
                            <h3 class="text-[15px] sm:text-[17px] font-bold text-gray-900 mt-1 leading-tight">{{ $p['name'] }}</h3>
                            <p class="text-[12.5px] text-green-600 font-semibold mt-1">{{ $p['free'] }} lockers free</p>

                            <div class="flex items-center justify-between mt-4">
                                <p class="text-[17px] font-extrabold text-[#0d2a52]">
                                    ${{ $p['price'] }}<span class="text-[12px] font-medium text-gray-500">/hr</span>
                                </p>
                                <a href="{{ route('location.show', $p['slug']) }}"
                                   class="bg-[#0d2a52] hover:bg-[#1e5fc4] text-white text-[13px] font-bold rounded-full px-5 py-2.5 no-underline transition">
                                    Book
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         6. HOW IT WORKS
         ============================================================ --}}
    <section class="w-full py-16">
        <div class="{{ $wrap }}">
            <div class="text-center mb-10">
                <p class="text-[12px] font-bold uppercase tracking-wider text-[#1e5fc4]">Simple</p>
                <h2 class="text-[24px] sm:text-[32px] font-extrabold text-gray-900 leading-tight">How It Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                @foreach ([
                    ['1', 'Find a location', 'Search or browse by category to find a place near you.'],
                    ['2', 'Choose a locker', 'Pick a size that fits your things and reserve it.'],
                    ['3', 'Store & unlock',  'Use your code or QR to open the locker anytime.'],
                ] as $s)
                    <div class="bg-white border border-gray-100 rounded-3xl p-7 sm:p-9 shadow-sm">
                        <span class="w-12 h-12 rounded-full bg-[#1e5fc4] text-white font-extrabold flex items-center justify-center text-[18px] mb-5">{{ $s[0] }}</span>
                        <p class="text-[18px] font-bold text-gray-900">{{ $s[1] }}</p>
                        <p class="text-[14px] text-gray-500 mt-2 leading-relaxed">{{ $s[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         7. CHOOSE YOUR SIZE
         ============================================================ --}}
    <section class="w-full bg-white py-16">
        <div class="{{ $wrap }} grid lg:grid-cols-3 gap-10 items-center">

            {{-- Left text --}}
            <div>
                <p class="text-[12px] font-bold uppercase tracking-wider text-[#1e5fc4]">Pricing</p>
                <h2 class="text-[24px] sm:text-[32px] font-extrabold text-gray-900 leading-tight">Choose Your Size</h2>
                <p class="text-[14.5px] text-gray-500 mt-3 leading-relaxed">
                    Pay only for the time you use. Every locker is clean, secure and ready when you are.
                </p>
            </div>

            {{-- Size cards --}}
            <div class="lg:col-span-2 grid grid-cols-3 gap-3 sm:gap-6">
                @foreach ($sizes as $s)
                    <div class="relative bg-white rounded-3xl p-4 sm:p-7 text-center shadow-sm transition hover:shadow-xl hover:-translate-y-1.5
                                {{ isset($s['best']) ? 'border-2 border-[#1e5fc4]' : 'border border-gray-100' }}">
                        @if (isset($s['best']))
                            <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#1e5fc4] text-white text-[11px] font-bold px-3 py-1 rounded-full whitespace-nowrap">Best value</span>
                        @endif

                        <div class="flex items-end justify-center h-24 mb-3">
                            <div class="w-14 {{ $s['h'] }} rounded-lg bg-[#eaf1fb] border-2 border-[#1e5fc4] relative">
                                <span class="absolute right-1.5 top-1/2 w-1.5 h-1.5 rounded-full bg-[#1e5fc4]"></span>
                            </div>
                        </div>

                        <p class="text-[16px] font-bold text-gray-900">{{ $s['name'] }}</p>
                        <p class="text-[12px] text-gray-500 mt-1 leading-snug hidden sm:block">{{ $s['desc'] }}</p>
                        <p class="text-[20px] font-extrabold text-[#0d2a52] mt-3">${{ $s['price'] }}<span class="text-[12px] font-medium text-gray-500">/hr</span></p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         8. FINAL CTA
         ============================================================ --}}
    <section class="relative w-full overflow-hidden text-white pt-16 pb-32"
             style="background: linear-gradient(135deg, #1e5fc4, #0d2a52 60%, #06142e);">
        <span class="absolute -right-16 -top-16 w-72 h-72 rounded-full bg-white/10"></span>
        <span class="absolute left-1/3 -bottom-24 w-64 h-64 rounded-full bg-white/10"></span>

        <div class="{{ $wrap }} relative z-10 text-center">
            <p class="text-[12px] font-bold uppercase tracking-wider text-white/70">Special offer</p>
            <h2 class="text-[30px] sm:text-[44px] font-extrabold leading-tight mt-2">Your first hour is on us</h2>
            <p class="text-[14.5px] sm:text-[16px] text-white/80 mt-3 max-w-xl mx-auto">
                Try Smart Locker today and see how easy it is to store your things.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8">
                <a href="{{ route('location') }}"
                   class="w-full sm:w-auto flex items-center justify-center gap-2.5 bg-white text-[#0d2a52] font-bold text-[15px] rounded-full px-9 py-4 no-underline shadow-lg transition hover:-translate-y-0.5">
                    Get Started
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                <a href="{{ route('location') }}"
                   class="w-full sm:w-auto text-center border border-white/40 hover:bg-white/10 text-white font-bold text-[15px] rounded-full px-9 py-4 no-underline transition">
                    Browse locations
                </a>
            </div>
        </div>
    </section>
</div>

{{-- Footer stays the same --}}
@include('partials.guest-footer')

@endsection