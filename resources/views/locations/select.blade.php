@extends('layouts.guest')

@section('title', 'Select Location | Smart Locker System')
@section('page_title', 'Select Location')

@section('content')
    @php
        // pill label => category name saved in the database
        $pills = [
            'All'      => 'all',
            'Mall'     => 'Shopping Mall',
            'Library'  => 'Library',
            'Building' => 'Building',
            'Sport'    => 'Sports Center',
        ];

        // background colors for locations without a photo (picked by id, so each one keeps its color)
        $gradients = [
            ['#1d4ed8', '#0b1f5c'], ['#be185d', '#500724'], ['#d97706', '#7c2d12'],
            ['#7c3aed', '#1e1b4b'], ['#0f766e', '#0c2d48'], ['#2563eb', '#172554'],
        ];
    @endphp

    {{-- pb-28 so the fixed bottom menu doesn't cover the last row --}}
    <div class="pb-28">

        {{-- Header band --}}
        <div class="bg-blue-900 text-white px-4 pt-10 pb-16">
            <div class="max-w-[1600px] mx-auto">
                <span class="inline-block bg-white/15 text-xs font-medium px-3 py-1 rounded-full mb-3">Step 1 of 3</span>
                <h1 class="text-3xl font-bold">Select Location</h1>
                <p class="text-blue-200 mt-1">Pick where you want to store your things.</p>

                <div class="relative mt-5 max-w-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.15a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                    </svg>
                    <input id="search" type="text" placeholder="Search location..."
                           class="w-full pl-11 pr-4 py-3 rounded-full text-gray-800 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="max-w-[1600px] mx-auto px-4 -mt-8">

            {{-- Filter bar (floats over the header) --}}
            <div class="bg-white rounded-2xl shadow-md px-4 py-3 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex flex-wrap gap-2">
                    @foreach ($pills as $label => $value)
                        <button type="button" data-cat="{{ $value }}"
                                class="pill px-5 py-2 rounded-full text-sm font-semibold transition {{ $loop->first ? 'bg-blue-700 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <label for="sort">Sort by</label>
                    <select id="sort" class="border border-gray-200 rounded-lg px-3 py-2 text-gray-800 font-medium focus:outline-none">
                        <option value="recommended">Recommended</option>
                        <option value="price-low">Price: low to high</option>
                        <option value="price-high">Price: high to low</option>
                        <option value="free">Most free lockers</option>
                    </select>
                </div>
            </div>

            <p class="text-gray-500 mt-6 mb-4">Showing <b id="count">{{ $locations->count() }}</b> locations</p>

            {{-- Location cards --}}
            <div id="grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($locations as $location)
                    @php
                        $free = $location->free_lockers;
                        [$c1, $c2] = $gradients[$location->id % count($gradients)];
                    @endphp

                    {{-- data-* attributes are what the search / filter / sort script reads --}}
                    <a href="{{ route('location.show', $location) }}"
                       class="location-card bg-white rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition overflow-hidden flex flex-col"
                       data-name="{{ strtolower($location->name . ' ' . $location->address) }}"
                       data-category="{{ $location->category }}"
                       data-price="{{ $location->price_per_hour }}"
                       data-free="{{ $free }}"
                       data-order="{{ $loop->index }}">

                        {{-- Photo or gradient --}}
                        <div class="relative h-[200px]" style="background: linear-gradient(135deg, {{ $c1 }}, {{ $c2 }});">
                            @if ($location->image)
                                <img src="{{ asset('storage/' . $location->image) }}" alt="{{ $location->name }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                            @endif

                            <span class="absolute top-4 left-4 bg-white text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-full">
                                {{ $location->category }}
                            </span>

                            {{-- 0 = Full, 5 or less = Almost full, otherwise N free --}}
                            @if ($free === 0)
                                <span class="absolute bottom-4 left-4 bg-red-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full">Full</span>
                            @elseif ($free <= 5)
                                <span class="absolute bottom-4 left-4 bg-orange-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full">Almost full</span>
                            @else
                                <span class="absolute bottom-4 left-4 bg-green-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full">{{ $free }} free</span>
                            @endif
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $location->name }}</h3>
                                @if ($location->rating)
                                    <span class="text-sm font-semibold text-gray-700 whitespace-nowrap">
                                        <span class="text-yellow-400">&#9733;</span> {{ $location->rating }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-500 mt-2 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $location->address }}
                            </p>

                            <div class="flex items-center justify-between border-t border-gray-100 mt-auto pt-4">
                                <p class="text-xl font-bold text-gray-900">
                                    ${{ number_format($location->price_per_hour, 2) }}<span class="text-sm font-normal text-gray-500">/hr</span>
                                </p>
                                {{-- span, not a button: the whole card is already a link --}}
                                <span class="bg-blue-900 text-white text-sm font-semibold px-6 py-3 rounded-full">Select &rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Shown when nothing matches (or there are no locations yet) --}}
            <div id="empty" class="hidden text-center py-16">
                <p class="text-lg font-semibold text-gray-700">No locations found</p>
                <p class="text-sm text-gray-400 mt-1">Try a different search or category.</p>
                <button id="reset" type="button" class="mt-4 bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-full">Reset</button>
            </div>

        </div>
    </div>

    <script>
        const grid   = document.getElementById('grid');
        const cards  = [...grid.querySelectorAll('.location-card')];
        const search = document.getElementById('search');
        const sort   = document.getElementById('sort');
        const pills  = document.querySelectorAll('.pill');
        const count  = document.getElementById('count');
        const empty  = document.getElementById('empty');
        let category = 'all';

        // Filter by category + search text, then sort, then redraw
        function apply() {
            const q = search.value.trim().toLowerCase();

            const visible = cards.filter(c =>
                (category === 'all' || c.dataset.category === category) &&
                c.dataset.name.includes(q)
            );

            visible.sort((a, b) => {
                if (sort.value === 'price-low')  return a.dataset.price - b.dataset.price;
                if (sort.value === 'price-high') return b.dataset.price - a.dataset.price;
                if (sort.value === 'free')       return b.dataset.free - a.dataset.free;
                return a.dataset.order - b.dataset.order;   // recommended = original order
            });

            cards.forEach(c => c.style.display = 'none');
            visible.forEach(c => { c.style.display = ''; grid.appendChild(c); });

            count.textContent = visible.length;
            empty.classList.toggle('hidden', visible.length > 0);
        }

        // Highlight the chosen pill
        function setCategory(value) {
            category = value;
            pills.forEach(p => {
                const on = p.dataset.cat === value;
                p.classList.toggle('bg-blue-700', on);
                p.classList.toggle('text-white', on);
                p.classList.toggle('bg-blue-50', !on);
                p.classList.toggle('text-blue-700', !on);
            });
            apply();
        }

        pills.forEach(p => p.addEventListener('click', () => setCategory(p.dataset.cat)));
        search.addEventListener('input', apply);
        sort.addEventListener('change', apply);

        document.getElementById('reset').addEventListener('click', () => {
            search.value = '';
            sort.value = 'recommended';
            setCategory('all');
        });

        // Links like /select-location?q=mall or ?category=Library pre-filter the page
        const params = new URLSearchParams(location.search);
        if (params.get('q')) search.value = params.get('q');
        setCategory(params.get('category') || 'all');
    </script>
@endsection