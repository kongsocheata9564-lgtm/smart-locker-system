@extends('layouts.guest')

@section('title', 'Smart Locker System')
@section('page_title', 'Welcome')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <h2 class="text-xl font-bold text-blue-900">Select Location</h2>

        <!-- Search input -->
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.15a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
            <input type="text"
                   name="search"
                   placeholder="Search location..."
                   class="w-full pl-11 pr-4 py-3 text-sm bg-white border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
        </div>

        <!-- Category filter pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <button type="button" class="shrink-0 bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-full">
                All
            </button>
            <button type="button" class="shrink-0 bg-blue-50 text-blue-600 text-sm font-medium px-4 py-2 rounded-full hover:bg-blue-100">
                Mall
            </button>
            <button type="button" class="shrink-0 bg-blue-50 text-blue-600 text-sm font-medium px-4 py-2 rounded-full hover:bg-blue-100">
                Library
            </button>
            <button type="button" class="shrink-0 bg-blue-50 text-blue-600 text-sm font-medium px-4 py-2 rounded-full hover:bg-blue-100">
                Building
            </button>
            <button type="button" class="shrink-0 bg-blue-50 text-blue-600 text-sm font-medium px-4 py-2 rounded-full hover:bg-blue-100">
                Sport
            </button>
        </div>

        <!-- Location list -->
        <div class="flex flex-col gap-3">

            <!-- ABC Mall -->
            {{-- TODO: replace href="#" with route('location.show', 'abc-mall') or similar --}}
            <a href="{{ route('location.show', 'abc-mall') }}" class="flex items-center gap-4 bg-white border-2 border-blue-500 rounded-xl p-3 shadow-sm cursor-pointer">
                <div class="w-16 h-16 shrink-0 rounded-lg bg-gray-100 overflow-hidden">
                    {{-- <img src="/path/to/abc-mall.jpg" alt="ABC Mall" class="w-full h-full object-cover"> --}}
                </div>
                <div>
                    <p class="font-semibold text-blue-900">ABC Mall</p>
                    <p class="text-sm text-gray-400">123, Monivong Blvd, Phnom Penh</p>
                </div>
            </a>

            <!-- National Library -->
            {{-- TODO: replace href="#" with route('location.show', 'national-library') or similar --}}
            <a href="#" class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-3 shadow-sm cursor-pointer hover:border-gray-200">
                <div class="w-16 h-16 shrink-0 rounded-lg bg-gray-100 overflow-hidden">
                    {{-- <img src="/path/to/national-library.jpg" alt="National Library" class="w-full h-full object-cover"> --}}
                </div>
                <div>
                    <p class="font-semibold text-blue-900">National Library</p>
                    <p class="text-sm text-gray-400">Preah Norodom Blvd, Phnom Penh</p>
                </div>
            </a>

            <!-- Sports Center -->
            {{-- TODO: replace href="#" with route('location.show', 'sports-center') or similar --}}
            <a href="#" class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-3 shadow-sm cursor-pointer hover:border-gray-200">
                <div class="w-16 h-16 shrink-0 rounded-lg bg-gray-100 overflow-hidden">
                    {{-- <img src="/path/to/sports-center.jpg" alt="Sports Center" class="w-full h-full object-cover"> --}}
                </div>
                <div>
                    <p class="font-semibold text-blue-900">Sports Center</p>
                    <p class="text-sm text-gray-400">Russian Blvd, Phnom Penh</p>
                </div>
            </a>

            <!-- University Building -->
            {{-- TODO: replace href="#" with route('location.show', 'university-building') or similar --}}
            <a href="#" class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-3 shadow-sm cursor-pointer hover:border-gray-200">
                <div class="w-16 h-16 shrink-0 rounded-lg bg-gray-100 overflow-hidden">
                    {{-- <img src="/path/to/university-building.jpg" alt="University Building" class="w-full h-full object-cover"> --}}
                </div>
                <div>
                    <p class="font-semibold text-blue-900">University Building</p>
                    <p class="text-sm text-gray-400">St. Veng Sreng Blvd, Phnom Penh</p>
                </div>
            </a>

        </div>

    </section>
@endsection