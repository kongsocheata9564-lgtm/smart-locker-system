@extends('layouts.guest')

@section('title', 'Smart Locker System')
@section('page_title', 'Select Location')

@section('content')

{{-- ============================================================
     DATA comes from the database ($locations is passed by LocationController@place)
     ============================================================ --}}
@php
    // Same inner container as the welcome page (backgrounds full width, content centered)
    $wrap = 'w-full max-w-[1600px] mx-auto px-5 sm:px-8 lg:px-12';

    // Filter pills: value => label
    $filters = ['all' => 'All', 'mall' => 'Mall', 'library' => 'Library', 'building' => 'Building', 'sport' => 'Sport'];

    // Label shown on the card for each category
    $catLabels = ['mall' => 'Shopping Mall', 'library' => 'Library', 'building' => 'Building', 'sport' => 'Sports Center'];

    // Category stored in the database -> key used by the filter buttons
    $catKeys = [
        'Shopping Mall' => 'mall',
        'Library'       => 'library',
        'Building'      => 'building',
        'Sports Center' => 'sport',
    ];

    // Card gradient per category (used when a location has no photo)
    $palette = [
        'mall'     => ['#1e5fc4', '#0d2a52'],
        'library'  => ['#be185d', '#4a044e'],
        'sport'    => ['#e07a1f', '#7a2a0c'],
        'building' => ['#6d4bd8', '#1b1a55'],
    ];

    // Turn database rows into the array shape the cards use
    $locations = collect($locations)->map(function ($l) use ($catKeys, $palette) {
        $key = $catKeys[$l->category] ?? 'building';

        return [
            'name'     => $l->name,
            'slug'     => $l->slug,
            'category' => $key,
            'address'  => $l->address,
            'price'    => number_format($l->price_per_hour, 2),
            'free'     => $l->free_lockers,
            'rating'   => $l->rating ? number_format($l->rating, 1) : null,
            'image'    => $l->image,
            'from'     => $palette[$key][0],
            'to'       => $palette[$key][1],
        ];
    })->values()->all();
@endphp

{{-- Whole page wrapper: full width + light gray background --}}
<div class="w-full bg-gray-50 text-left min-h-screen">

    {{-- ============================================================
         1. HEADER BAND (blue, full width) with title + search
         ============================================================ --}}
    <section class="relative w-full overflow-hidden text-white pt-10 pb-16 sm:pt-14 sm:pb-20"
             style="background: linear-gradient(135deg, #1e5fc4, #0d2a52 60%, #06142e);">
        {{-- Decorative circles --}}
        <span class="absolute -right-16 -top-16 w-72 h-72 rounded-full bg-white/10"></span>
        <span class="absolute left-1/3 -bottom-24 w-64 h-64 rounded-full bg-white/10"></span>

        <div class="{{ $wrap }} relative z-10">
            {{-- Step badge --}}
            <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur px-3.5 py-1.5 rounded-full text-[12px] font-semibold mb-4">
                Step 1 of 3 &middot; Choose a location
            </span>

            <h1 class="text-[30px] sm:text-[44px] font-extrabold leading-tight tracking-tight">Select Location</h1>
            <p class="text-[14.5px] sm:text-[16px] text-white/80 mt-2 max-w-xl">
                Pick a place near you to see available lockers.
            </p>

            {{-- Search bar (filters the cards below instantly, no page reload) --}}
            <div class="bg-white rounded-2xl flex items-center gap-2 p-2 pl-5 shadow-2xl max-w-2xl mt-7">
                <svg class="w-5 h-5 text-[#1e5fc4] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="locSearch" type="text" name="search" placeholder="Search location (e.g. ABC Mall)"
                       class="flex-1 min-w-0 border-0 outline-none focus:ring-0 text-[14px] sm:text-[15px] text-gray-900 placeholder-gray-400 bg-transparent">
                {{-- Clear button (shows only when there is text) --}}
                <button id="locClear" type="button" aria-label="Clear"
                        class="hidden w-8 h-8 rounded-full hover:bg-gray-100 text-gray-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24">
                        <line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- ============================================================
         2. TOOLBAR (filter pills + sort) - floats over the header band
         ============================================================ --}}
    <section class="{{ $wrap }} -mt-8 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl px-4 py-3 sm:px-5 sm:py-4 flex flex-col sm:flex-row sm:items-center gap-3 sm:justify-between">

            {{-- Category pills (scroll sideways on small phones) --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                @foreach ($filters as $value => $label)
                    <button type="button" data-filter="{{ $value }}"
                            class="filter-pill shrink-0 text-[13px] font-semibold px-4 py-2 rounded-full transition
                                   {{ $value === 'all' ? 'bg-[#1e5fc4] text-white' : 'bg-[#eaf1fb] text-[#1e5fc4] hover:bg-[#dbe8fb]' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Sort dropdown --}}
            <div class="flex items-center gap-2 shrink-0">
                <label for="locSort" class="text-[12.5px] text-gray-500 font-medium">Sort by</label>
                <select id="locSort"
                        class="text-[13px] font-semibold text-gray-800 bg-gray-50 border border-gray-200 rounded-xl pl-3 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="recommended">Recommended</option>
                    <option value="free">Most free lockers</option>
                    <option value="price">Lowest price</option>
                    <option value="rating">Top rated</option>
                </select>
            </div>
        </div>
    </section>

    {{-- ============================================================
         3. LOCATION GRID
         pb-32 = extra space so the fixed bottom menu doesn't cover the last row
         ============================================================ --}}
    <section class="{{ $wrap }} pt-8 pb-32">

        {{-- Result count --}}
        <p class="text-[13.5px] text-gray-500 mb-4">
            Showing <span id="locCount" class="font-bold text-gray-900">{{ count($locations) }}</span> locations
        </p>

        <div id="locGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($locations as $i => $loc)
                {{-- The whole card is a link. data-* attributes are used by the JS filter/sort below --}}
                <a href="{{ route('location.show', $loc['slug']) }}"
                   data-card
                   data-index="{{ $i }}"
                   data-category="{{ $loc['category'] }}"
                   data-name="{{ $loc['name'] }}"
                   data-address="{{ $loc['address'] }}"
                   data-price="{{ $loc['price'] }}"
                   data-free="{{ $loc['free'] }}"
                   data-rating="{{ $loc['rating'] ?? 0 }}"
                   class="group bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm no-underline transition hover:shadow-2xl hover:-translate-y-1.5">

                    {{-- Image area: uploaded photo if there is one, otherwise a gradient --}}
                    <div class="relative h-40 flex items-center justify-center"
                         style="background: linear-gradient(135deg, {{ $loc['from'] }}, {{ $loc['to'] }});">
                        @if ($loc['image'])
                            <img src="{{ asset('storage/' . $loc['image']) }}" alt="{{ $loc['name'] }}"
                                 class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-white/25 transition group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/>
                                <rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/>
                            </svg>
                        @endif

                        {{-- Category badge (top left) --}}
                        <span class="absolute top-3 left-3 bg-white text-[#0d2a52] text-[11px] font-bold px-3 py-1 rounded-full shadow">
                            {{ $catLabels[$loc['category']] }}
                        </span>

                        {{-- Availability badge (bottom left): orange when almost full, green otherwise --}}
                        <span class="absolute bottom-3 left-3 flex items-center gap-1.5 text-white text-[11.5px] font-bold px-3 py-1 rounded-full
                                     {{ $loc['free'] <= 5 ? 'bg-orange-500' : 'bg-green-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            {{ $loc['free'] <= 5 ? 'Almost full' : $loc['free'] . ' free' }}
                        </span>
                    </div>

                    {{-- Card body --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="text-[17px] font-bold text-gray-900 leading-tight">{{ $loc['name'] }}</h3>
                            @if ($loc['rating'])
                                <p class="text-[12.5px] font-bold text-gray-800 flex items-center gap-1 shrink-0">
                                    <span class="text-amber-400">&#9733;</span>{{ $loc['rating'] }}
                                </p>
                            @endif
                        </div>

                        {{-- Address with pin icon --}}
                        <p class="flex items-start gap-1.5 text-[12.5px] text-gray-500 mt-2 leading-snug">
                            <svg class="w-4 h-4 shrink-0 mt-px text-gray-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ $loc['address'] }}
                        </p>

                        {{-- Price + select button --}}
                        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                            <p class="text-[18px] font-extrabold text-[#0d2a52]">
                                ${{ $loc['price'] }}<span class="text-[12px] font-medium text-gray-500">/hr</span>
                            </p>
                            <span class="bg-[#0d2a52] group-hover:bg-[#1e5fc4] text-white text-[13px] font-bold rounded-full px-5 py-2.5 transition">
                                Select &rarr;
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Empty state (hidden until nothing matches) --}}
        <div id="locEmpty" class="hidden text-center py-16">
            <span class="w-16 h-16 rounded-full bg-[#eaf1fb] text-[#1e5fc4] flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>
            <p class="text-[17px] font-bold text-gray-900">No locations found</p>
            <p class="text-[13.5px] text-gray-500 mt-1">Try a different name or choose another category.</p>
            <button id="locReset" type="button"
                    class="mt-5 bg-[#1e5fc4] hover:bg-[#17488a] text-white text-[13.5px] font-bold rounded-full px-6 py-3 transition">
                Reset filters
            </button>
        </div>
    </section>
</div>

{{-- ============================================================
     4. SMALL SCRIPT: search + category filter + sort (plain JavaScript)
     ============================================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Grab the elements we need
    var grid       = document.getElementById('locGrid');
    var cards      = Array.prototype.slice.call(grid.querySelectorAll('[data-card]'));
    var searchEl   = document.getElementById('locSearch');
    var clearBtn   = document.getElementById('locClear');
    var sortEl     = document.getElementById('locSort');
    var countEl    = document.getElementById('locCount');
    var emptyEl    = document.getElementById('locEmpty');
    var resetBtn   = document.getElementById('locReset');
    var pills      = document.querySelectorAll('.filter-pill');

    var activeCat = 'all'; // currently selected category

    // Classes used to style the active / inactive pill
    var ON  = ['bg-[#1e5fc4]', 'text-white'];
    var OFF = ['bg-[#eaf1fb]', 'text-[#1e5fc4]', 'hover:bg-[#dbe8fb]'];

    // Main function: filter + sort + show
    function render() {
        var q = searchEl.value.trim().toLowerCase();

        // 1) keep only cards that match category AND search text
        var visible = cards.filter(function (c) {
            var okCat  = activeCat === 'all' || c.dataset.category === activeCat;
            var text   = (c.dataset.name + ' ' + c.dataset.address).toLowerCase();
            return okCat && text.indexOf(q) !== -1;
        });

        // 2) sort the visible cards
        var s = sortEl.value;
        visible.sort(function (a, b) {
            if (s === 'free')   return b.dataset.free - a.dataset.free;        // most free first
            if (s === 'price')  return a.dataset.price - b.dataset.price;      // cheapest first
            if (s === 'rating') return b.dataset.rating - a.dataset.rating;    // best rated first
            return a.dataset.index - b.dataset.index;                           // original order
        });

        // 3) hide everything, then show + reorder the matches
        cards.forEach(function (c) { c.classList.add('hidden'); });
        visible.forEach(function (c) {
            c.classList.remove('hidden');
            grid.appendChild(c); // appendChild moves the card = re-orders it
        });

        // 4) update count, empty state, and clear button
        countEl.textContent = visible.length;
        emptyEl.classList.toggle('hidden', visible.length !== 0);
        clearBtn.classList.toggle('hidden', q === '');
    }

    // Set the active pill (also changes its colors)
    function setCategory(cat) {
        activeCat = cat;
        pills.forEach(function (p) {
            var on = p.dataset.filter === cat;
            ON.forEach(function (cl) { p.classList.toggle(cl, on); });
            OFF.forEach(function (cl) { p.classList.toggle(cl, !on); });
        });
        render();
    }

    // Events
    searchEl.addEventListener('input', render);
    sortEl.addEventListener('change', render);
    pills.forEach(function (p) {
        p.addEventListener('click', function () { setCategory(p.dataset.filter); });
    });
    clearBtn.addEventListener('click', function () { searchEl.value = ''; render(); searchEl.focus(); });
    resetBtn.addEventListener('click', function () { searchEl.value = ''; sortEl.value = 'recommended'; setCategory('all'); });

    // Read ?q=ABC or ?category=shopping from the URL (so the welcome page links can work here too)
    var params = new URLSearchParams(window.location.search);
    var alias  = { shopping: 'mall', libraries: 'library', buildings: 'building', sports: 'sport' }; // welcome page names -> this page names
    if (params.get('q')) { searchEl.value = params.get('q'); }
    var catParam = params.get('category');
    if (catParam) { setCategory(alias[catParam] || catParam); } else { render(); }
});
</script>

@endsection