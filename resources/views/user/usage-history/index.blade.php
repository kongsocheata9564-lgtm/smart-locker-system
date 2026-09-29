@extends('layouts.user')

@section('title', 'Usage History | Smart Locker System')
@section('page_title', 'Usage History')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <div>
            <h2 class="text-lg font-bold text-gray-800">Usage History</h2>
            <p class="text-sm text-gray-400">Track your locker usage and booking history.</p>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

            <!-- Locations filter -->
            <div class="relative w-full sm:w-44">
                <select name="location"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-white border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Locations</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Status filter -->
            <div class="relative w-full sm:w-40">
                <select name="status"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-white border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Date range (static text for now) -->
            <button type="button"
                    class="flex items-center gap-2 bg-white border border-gray-200 text-sm text-gray-600 px-4 py-2.5 rounded-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
                </svg>
                Sep 1, 2025 - Sep 28, 2026
            </button>

        </div>

        <!-- History table -->
        <div class="border border-gray-100 rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="font-medium px-4 py-3 w-10">#</th>
                        <th class="font-medium px-4 py-3">Locker</th>
                        <th class="font-medium px-4 py-3">Location</th>
                        <th class="font-medium px-4 py-3">Type</th>
                        <th class="font-medium px-4 py-3">Time</th>
                        <th class="font-medium px-4 py-3">Status</th>
                    </tr>
                </thead>
               @php
    $icons = [
        'checkins' => 'M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z',
        'releases' => 'M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21M6.375 6.375l1.06 1.06m9.129 9.129l1.06 1.06m0-11.25l-1.06 1.06m-9.129 9.129l-1.06 1.06M12 9a3 3 0 100 6 3 3 0 000-6z',
        'users'    => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
        'duration' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $poly = fn ($pts) => collect($pts)->map(fn ($p) => $p[0] . ',' . $p[1])->implode(' ');
    $area = fn ($pts) => count($pts) ? $poly($pts) . ' ' . $pts[count($pts) - 1][0] . ',170 ' . $pts[0][0] . ',170' : '';

    $topMax = max(1, (int) ($top->max('total') ?? 1));
@endphp

<section class="grid gap-4 p-3 rounded-xl bg-white">

    <!-- Page header + date range -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Locker Usage</h2>
            <p class="text-sm text-gray-400">
                {{ $mine ? 'Your locker usage and activity.' : 'Track locker usage and activity logs.' }}
            </p>
        </div>

        <form method="GET" class="flex flex-wrap items-center gap-2 bg-white border border-gray-200 rounded-lg shadow-sm px-3 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
            </svg>
            <input type="date" name="from" value="{{ $from->toDateString() }}" max="{{ now()->toDateString() }}"
                   class="text-sm text-gray-600 border-0 outline-none bg-transparent">
            <span class="text-gray-300">–</span>
            <input type="date" name="to" value="{{ $to->toDateString() }}" max="{{ now()->toDateString() }}"
                   class="text-sm text-gray-600 border-0 outline-none bg-transparent">
            <button type="submit" class="ml-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Apply</button>
        </form>
    </div>

    @error('from') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    @error('to') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

    <!-- Stats row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($cards as $card)
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$card['key']] }}" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">{{ $card['label'] }}</p>
                    <p class="text-xl font-semibold text-gray-800">{{ $card['value'] }}</p>
                    @if ($card['change'] === null)
                        <p class="text-xs text-gray-400">{{ $card['note'] ?? 'No data for the previous period' }}</p>
                    @else
                        <p class="text-xs {{ $card['change'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $card['change'] >= 0 ? '+' : '' }}{{ $card['change'] }}% vs previous period
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Usage Trend -->
        <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700">Usage Trend</h3>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Check-ins</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-teal-400"></span> Releases</span>
                </div>
            </div>

            <div class="flex gap-2">
                <!-- Y-axis labels -->
                <div class="flex flex-col justify-between text-xs text-gray-400 py-1" style="height: 190px;">
                    <span>{{ $chart['yMax'] }}</span>
                    <span>{{ round($chart['yMax'] / 2) }}</span>
                    <span>0</span>
                </div>

                <div class="flex-1 min-w-0">
                    <svg viewBox="0 0 600 190" class="w-full h-48" preserveAspectRatio="none">
                        <line x1="0" y1="10"  x2="600" y2="10"  stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="90"  x2="600" y2="90"  stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="170" x2="600" y2="170" stroke="#e2e8f0" stroke-width="1" />

                        {{-- Check-ins --}}
                        <polygon points="{{ $area($chart['in']) }}" fill="#3b82f6" fill-opacity="0.08" />
                        <polyline points="{{ $poly($chart['in']) }}" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                        @foreach ($chart['in'] as $p)
                            <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="4" fill="#3b82f6" />
                        @endforeach

                        {{-- Releases --}}
                        <polygon points="{{ $area($chart['out']) }}" fill="#2dd4bf" fill-opacity="0.08" />
                        <polyline points="{{ $poly($chart['out']) }}" fill="none" stroke="#2dd4bf" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                        @foreach ($chart['out'] as $p)
                            <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="4" fill="#2dd4bf" />
                        @endforeach
                    </svg>

                    <!-- X-axis labels -->
                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                        @foreach ($chart['xLabels'] as $label)
                            <span>{{ $label }}</span>
                        @endforeach
                    </div>

                    @if ($chart['empty'])
                        <p class="text-xs text-gray-400 text-center mt-3">No usage in this period.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Locations -->
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Top Locations</h3>

            <div class="flex justify-between text-xs text-gray-400 mb-2">
                <span>Location</span>
                <span>Usage</span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse ($top as $row)
                    <div>
                        <div class="flex justify-between text-sm text-gray-700 mb-1">
                            <span class="truncate pr-2">{{ $row->name }}</span>
                            <span class="font-medium">{{ $row->total }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ round($row->total / $topMax * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 py-4 text-center">No usage in this period.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>
            </table>
        </div>

    </section>
@endsection