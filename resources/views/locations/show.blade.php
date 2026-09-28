@extends('layouts.guest')

@section('title', 'ABC Mall | Smart Locker System')
@section('page_title', 'Location Detail')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <!-- Location header -->
        <div>
            <h2 class="text-xl font-bold text-blue-900">ABC Mall</h2>
            <p class="text-sm text-gray-400">123, Monivong Blvd, Phnom Penh</p>
        </div>

        <!-- Location image banner -->
        <div class="w-full h-32 rounded-xl bg-gray-100 overflow-hidden">
            {{-- <img src="/path/to/abc-mall-banner.jpg" alt="ABC Mall" class="w-full h-full object-cover"> --}}
        </div>

        <!-- Locker Availability -->
        <div>
            <h3 class="text-base font-semibold text-gray-800 mb-3">Locker Availability</h3>

            <!-- Legend -->
            <div class="flex items-center gap-4 text-sm mb-4">
                <span class="flex items-center gap-1.5 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Available 12
                </span>
                <span class="flex items-center gap-1.5 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> In Use 8
                </span>
                <span class="flex items-center gap-1.5 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Maintenance 2
                </span>
            </div>

            <!-- Locker grid -->
            <div class="grid grid-cols-3 gap-3">

                <!-- L-001 Available -->
                <a href="{{ route('locker.show', 'L-001') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-green-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-001</p>
                    <span class="text-xs font-medium text-green-500">Available</span>
                </a>

                <!-- L-002 In Use -->
                <a href="{{ route('locker.show', 'L-002') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-red-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-002</p>
                    <span class="text-xs font-medium text-red-500">In Use</span>
                </a>

                <!-- L-003 Maintenance -->
                <a href="{{ route('locker.show', 'L-003') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-orange-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L1.5 3l1.5-1.5L7.5 4.5v1.409l4.26 4.26" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-003</p>
                    <span class="text-xs font-medium text-orange-500">Maintenance</span>
                </a>

                <!-- L-004 Available -->
                <a href="{{ route('locker.show', 'L-004') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-green-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-004</p>
                    <span class="text-xs font-medium text-green-500">Available</span>
                </a>

                <!-- L-005 Available -->
                <a href="{{ route('locker.show', 'L-005') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-green-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-005</p>
                    <span class="text-xs font-medium text-green-500">Available</span>
                </a>

                <!-- L-006 Available -->
                <a href="{{ route('locker.show', 'L-006') }}"
                   class="flex flex-col items-center gap-2 bg-white border border-green-100 rounded-xl p-3 shadow-sm hover:shadow-md transition">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">L-006</p>
                    <span class="text-xs font-medium text-green-500">Available</span>
                </a>

            </div>
        </div>

        <!-- View all button -->
        <a href="#" class="text-center text-sm font-medium text-blue-500 hover:text-blue-600 py-2">
            View All Lockers (24)
        </a>

    </section>
@endsection