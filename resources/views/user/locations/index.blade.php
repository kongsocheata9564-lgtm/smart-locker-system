
@extends('layouts.user')

@section('title', 'Locations | Smart Locker System')
@section('page_title', 'Locations')
@section('page_subtitle', 'Find and choose a location to use our smart lockers.')

@section('content')

    <div class="space-y-6">

        {{-- Select Location Box --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900">
                    Select Location
                </h2>
            </div>

            {{-- Search Bar --}}
            <div class="relative max-w-full mb-5">

                <svg
                    class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"
                    />
                </svg>

                <input
                    id="search"
                    type="text"
                    placeholder="Search location..."
                    class="w-full pl-12 pr-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-900 bg-gray-50/50"
                >

            </div>

            {{-- Category Filter Pills --}}
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" class="filter-btn px-5 py-2 text-sm font-medium rounded-full bg-blue-600 text-white transition shadow-sm" data-category="all">
                    All
                </button>
              
                <button type="button" class="filter-btn px-5 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition" data-category="library">
                    Library
                </button>
                <button type="button" class="filter-btn px-5 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition" data-category="building">
                    Building
                </button>
                <button type="button" class="filter-btn px-5 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition" data-category="sports">
                    Sports
                </button>
            </div>

        </div>


        {{-- Locations Grid --}}
        <div
            id="locationList"
            class="grid grid-cols-1 md:grid-cols-2 gap-4"
        >

            @forelse ($locations as $location)

                <a
                    href="{{ route('user.locations.lockers', $location) }}"
                    class="location-card bg-white rounded-2xl border border-gray-200/80 p-5 hover:shadow-md hover:border-blue-500 transition flex items-center justify-between group"
                    data-name="{{ strtolower($location->name . ' ' . $location->address) }}"
                    data-category="{{ strtolower($location->type ?? 'building') }}"
                >

                    <div class="flex items-center gap-4">
{{-- Location Map/Image --}}
<div class="w-24 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
    @if ($location->map)
        <img
            src="{{ $location->map }}"
            alt="{{ $location->name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
        >
    @else
        <iframe
            src="https://maps.google.com/maps?q={{ urlencode($location->name . ', ' . $location->address) }}&z=15&output=embed"
            class="w-full h-full border-0 pointer-events-none"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    @endif
</div>

                        {{-- Location Info --}}
                        <div>
                            <h3 class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition">
                                {{ $location->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $location->address }}
                            </p>
                        </div>

                    </div>

                    {{-- Arrow Icon --}}
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 group-hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                </a>

            @empty

                <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-10 text-center">
                    <p class="text-gray-500">
                        No locations available.
                    </p>
                </div>

            @endforelse

        </div>

    </div>


    {{-- Search and Filter Script --}}
    <script>
        const searchInput = document.getElementById('search');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const locationCards = document.querySelectorAll('.location-card');

        let currentSearch = '';
        let currentCategory = 'all';

        function filterLocations() {
            locationCards.forEach(card => {
                const name = card.dataset.name;
                const category = card.dataset.category;

                const matchesSearch = name.includes(currentSearch);
                const matchesCategory = currentCategory === 'all' || category.includes(currentCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search event
        searchInput.addEventListener('input', function () {
            currentSearch = this.value.toLowerCase();
            filterLocations();
        });

        // Category filter buttons event
        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                    btn.classList.add('bg-gray-100', 'text-gray-600');
                });

                this.classList.remove('bg-gray-100', 'text-gray-600');
                this.classList.add('bg-blue-600', 'text-white', 'shadow-sm');

                currentCategory = this.dataset.category;
                filterLocations();
            });
        });
    </script>

@endsection