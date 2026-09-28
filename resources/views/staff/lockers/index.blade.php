@extends('layouts.app1')

@section('title', 'Lockers | Smart Locker System')
@section('page_title', 'Lockers')

@section('content')
@php
    $statusBadge = [
        'available'   => ['bg-green-50 text-green-500',   'Available'],
        'occupied'    => ['bg-blue-50 text-blue-500',     'In Use'],
        'maintenance' => ['bg-orange-50 text-orange-500', 'Maintenance'],
    ];
@endphp
    <section class="grid gap-4 p-3 rounded-xl bg-white">

        <!-- Page header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Lockers</h2>
                <p class="text-sm text-gray-400">Manage all lockers across locations.</p>
            </div>

            <a href="#"
               class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Locker
            </a>
        </div>

        <!-- Search + filters bar -->
        <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white border border-gray-100 rounded-xl p-3 shadow-sm">

            <!-- Search input -->
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.15a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Search locker number..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
            </div>

            <!-- Locations filter -->
            <select name="location" onchange="this.form.submit()"
                    class="w-full sm:w-48 pl-3 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                <option value="">All Locations</option>
                @foreach ($locations as $loc)
                    <option value="{{ $loc->id }}" @selected((string) request('location') === (string) $loc->id)>{{ $loc->name }}</option>
                @endforeach
            </select>

            <!-- Status filter -->
            <select name="status" onchange="this.form.submit()"
                    class="w-full sm:w-40 pl-3 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                <option value="">All Status</option>
                <option value="available"   @selected(request('status') === 'available')>Available</option>
                <option value="occupied"    @selected(request('status') === 'occupied')>In Use</option>
                <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
            </select>

            <button type="submit" class="px-4 py-2.5 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium">Search</button>

            @if (request()->hasAny(['q', 'location', 'status']))
                <a href="{{ route('staff.lockers.index') }}" class="text-center text-sm text-gray-500 hover:text-gray-700 no-underline">Reset</a>
            @endif
        </form>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="font-medium px-4 py-3 w-10">#</th>
                        <th class="font-medium px-4 py-3">Locker #</th>
                        <th class="font-medium px-4 py-3">Location</th>
                        <th class="font-medium px-4 py-3">Type</th>
                        <th class="font-medium px-4 py-3">Status</th>
                        <th class="font-medium px-4 py-3">Last Used</th>
                        <th class="font-medium px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($lockers as $locker)
                        @php
                            $badge = $statusBadge[$locker->status] ?? ['bg-gray-100 text-gray-500', ucfirst($locker->status)];
                            $lastUsed = $locker->usages_max_start_time
                                ? \Illuminate\Support\Carbon::parse($locker->usages_max_start_time)->diffForHumans()
                                : '-';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500">{{ $lockers->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                            <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                            <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                            <rect x="13" y="13" width="7" height="7" rx="1.2" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ $locker->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $locker->location->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ ucfirst($locker->type) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center {{ $badge[0] }} text-xs font-medium px-2.5 py-1 rounded-full">{{ $badge[1] }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-400">{{ $lastUsed }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('locker.show', $locker) }}" class="text-xs font-medium text-blue-500 hover:underline no-underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">No lockers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $lockers->links() }}</div>

    </section>
@endsection