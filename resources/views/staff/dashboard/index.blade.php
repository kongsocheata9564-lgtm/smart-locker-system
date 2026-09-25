@extends('layouts.app')

@section('title', 'Dashboard | Smart Locker System')
@section('page_title', 'Dashboard')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <!-- Stats row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Total Locations -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <!-- location pin icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Locations</p>
                    <p class="text-xl font-semibold text-gray-800">4</p>
                    <p class="text-xs text-gray-400">All active</p>
                </div>
            </div>

            <!-- Total Lockers -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500">
                    <!-- locker/grid icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="7" height="7" rx="1.2" />
                        <rect x="13" y="4" width="7" height="7" rx="1.2" />
                        <rect x="4" y="13" width="7" height="7" rx="1.2" />
                        <rect x="13" y="13" width="7" height="7" rx="1.2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Lockers</p>
                    <p class="text-xl font-semibold text-gray-800">20</p>
                    <p class="text-xs text-green-500">+16 available</p>
                </div>
            </div>

            <!-- Active Users -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-purple-50 text-purple-500">
                    <!-- users icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-5.13a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 100-8" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Active Users</p>
                    <p class="text-xl font-semibold text-gray-800">48</p>
                    <p class="text-xs text-green-500">+12% this week</p>
                </div>
            </div>

            <!-- Current Usage -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                    <!-- percent icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 5L5 19M7 7.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm10 13a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Current Usage</p>
                    <p class="text-xl font-semibold text-gray-800">19%</p>
                    <p class="text-xs text-gray-400">95% accuracy</p>
                </div>
            </div>

        </div>
        <!-- ^ closes the stats row grid -->

        <!-- Second row: Locker Status + Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Locker Status Overview -->
            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Locker Status Overview</h3>

                <div class="flex items-center gap-6">
                    <!-- Donut chart -->
                    <div class="relative w-40 h-40 shrink-0">
                        <svg viewBox="0 0 160 160" class="w-40 h-40 -rotate-90">
                            <!-- track -->
                            <circle cx="80" cy="80" r="64" fill="none" stroke="#f1f5f9" stroke-width="18" />

                            <!-- Available 60% -->
                            <circle cx="80" cy="80" r="64" fill="none" stroke="#22c55e" stroke-width="18"
                                stroke-dasharray="241.26 402.1" stroke-dashoffset="0" stroke-linecap="round" />

                            <!-- In Use 30% -->
                            <circle cx="80" cy="80" r="64" fill="none" stroke="#3b82f6" stroke-width="18"
                                stroke-dasharray="120.63 402.1" stroke-dashoffset="-241.26" stroke-linecap="round" />

                            <!-- Maintenance 10% -->
                            <circle cx="80" cy="80" r="64" fill="none" stroke="#f97316" stroke-width="18"
                                stroke-dasharray="40.21 402.1" stroke-dashoffset="-361.89" stroke-linecap="round" />
                        </svg>

                        <!-- Center label -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <p class="text-2xl font-bold text-gray-800">20</p>
                            <p class="text-xs text-gray-400">Total Lockers</p>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-sm text-gray-600">Available</span>
                            <span class="text-sm font-semibold text-gray-800 ml-auto">12 (60%)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="text-sm text-gray-600">In Use</span>
                            <span class="text-sm font-semibold text-gray-800 ml-auto">6 (30%)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                            <span class="text-sm text-gray-600">Maintenance</span>
                            <span class="text-sm font-semibold text-gray-800 ml-auto">2 (10%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Recent Activity</h3>
                    <a href="#" class="text-xs text-blue-500 hover:underline">View all</a>
                </div>

                <div class="flex flex-col divide-y divide-gray-50">

                    <!-- Item -->
                    <div class="flex items-start gap-3 py-3">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-50 text-green-500 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">User <span class="font-medium">#U-021</span> checked in</p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">2 min ago</span>
                    </div>

                    <!-- Item -->
                    <div class="flex items-start gap-3 py-3">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">Maintenance reported <span class="font-medium">L-004</span></p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">10 min ago</span>
                    </div>

                    <!-- Item -->
                    <div class="flex items-start gap-3 py-3">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zM12 14v7m-4-4h8" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">User <span class="font-medium">#U-017</span> released locker</p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">25 min ago</span>
                    </div>

                    <!-- Item -->
                    <div class="flex items-start gap-3 py-3">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-purple-50 text-purple-500 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">New user registered <span class="font-medium">Sokha Chheang</span></p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">1 hr ago</span>
                    </div>

                </div>
            </div>

        </div>

    </section>
@endsection