@extends('layouts.app')

@section('title', 'Dashboard | Smart Locker System')
@section('page_title', 'Dashboard')

@section('content')
@php
    // Donut chart math: circumference of a circle with r = 64
    $circ = 402.12;
    $segments = [
        ['label' => 'Available',   'count' => $available,   'color' => '#22c55e', 'dot' => 'bg-green-500'],
        ['label' => 'In Use',      'count' => $occupied,    'color' => '#3b82f6', 'dot' => 'bg-blue-500'],
        ['label' => 'Maintenance', 'count' => $maintenance, 'color' => '#f97316', 'dot' => 'bg-orange-500'],
    ];
    $offset = 0;

    // Icon look for each activity type
    $activityStyle = [
        'user'        => ['bg' => 'bg-purple-50', 'text' => 'text-purple-500', 'path' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        'location'    => ['bg' => 'bg-green-50',  'text' => 'text-green-500',  'path' => 'M5 13l4 4L19 7'],
        'maintenance' => ['bg' => 'bg-red-50',    'text' => 'text-red-500',    'path' => 'M12 9v3.75m0 3.75h.007v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        'in_use'      => ['bg' => 'bg-blue-50',   'text' => 'text-blue-500',   'path' => 'M16 12a4 4 0 10-8 0 4 4 0 008 0zM12 14v7m-4-4h8'],
    ];
@endphp

    <section class="grid gap-4 bg-white rounded-xl p-4">

        <!-- Stats row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Total Locations -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Locations</p>
                    <p class="text-xl font-semibold text-gray-800">{{ number_format($locationCount) }}</p>
                    <p class="text-xs text-gray-400">{{ $categoryCount }} {{ $categoryCount === 1 ? 'category' : 'categories' }}</p>
                </div>
            </div>

            <!-- Total Lockers -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="7" height="7" rx="1.2" />
                        <rect x="13" y="4" width="7" height="7" rx="1.2" />
                        <rect x="4" y="13" width="7" height="7" rx="1.2" />
                        <rect x="13" y="13" width="7" height="7" rx="1.2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Lockers</p>
                    <p class="text-xl font-semibold text-gray-800">{{ number_format($lockerTotal) }}</p>
                    <p class="text-xs text-green-500">{{ number_format($available) }} available</p>
                </div>
            </div>

            <!-- Active Users -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-purple-50 text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-5.13a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 100-8" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Active Users</p>
                    <p class="text-xl font-semibold text-gray-800">{{ number_format($activeUsers) }}</p>
                    <p class="text-xs {{ $newUsersWeek > 0 ? 'text-green-500' : 'text-gray-400' }}">
                        {{ $newUsersWeek > 0 ? '+' . $newUsersWeek . ' this week' : 'No new users this week' }}
                    </p>
                </div>
            </div>

            <!-- Current Usage -->
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-orange-50 text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 5L5 19M7 7.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm10 13a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Current Usage</p>
                    <p class="text-xl font-semibold text-gray-800">{{ $usagePct }}%</p>
                    <p class="text-xs text-gray-400">{{ number_format($occupied) }} in use</p>
                </div>
            </div>

        </div>

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

                            @if ($lockerTotal > 0)
                                @foreach ($segments as $seg)
                                    @if ($seg['count'] > 0)
                                        @php
                                            $len = $seg['count'] / $lockerTotal * $circ;
                                        @endphp
                                        <circle cx="80" cy="80" r="64" fill="none" stroke="{{ $seg['color'] }}" stroke-width="18"
                                            stroke-dasharray="{{ round($len, 2) }} {{ $circ }}"
                                            stroke-dashoffset="{{ round(-$offset, 2) }}" />
                                        @php $offset += $len; @endphp
                                    @endif
                                @endforeach
                            @endif
                        </svg>

                        <!-- Center label -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($lockerTotal) }}</p>
                            <p class="text-xs text-gray-400">Total Lockers</p>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-col gap-3 flex-1">
                        @foreach ($segments as $seg)
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $seg['dot'] }}"></span>
                                <span class="text-sm text-gray-600">{{ $seg['label'] }}</span>
                                <span class="text-sm font-semibold text-gray-800 ml-auto">
                                    {{ $seg['count'] }} ({{ $lockerTotal ? round($seg['count'] / $lockerTotal * 100) : 0 }}%)
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($lockerTotal === 0)
                    <p class="text-xs text-gray-400 mt-4">No lockers yet. Add lockers to see the chart.</p>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Recent Activity</h3>
                    <a href="{{ route('staff.usage-history.index') }}" class="text-xs text-blue-500 hover:underline">View all</a>
                </div>

                <div class="flex flex-col divide-y divide-gray-50">
                    @forelse ($activity as $item)
                        @php $s = $activityStyle[$item['type']]; @endphp
                        <div class="flex items-start gap-3 py-3">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $s['bg'] }} {{ $s['text'] }} shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['path'] }}" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">{{ $item['text'] }} <span class="font-medium">{{ $item['strong'] }}</span></p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ $item['time']->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-6 text-center">No activity yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </section>
@endsection