@extends('layouts.app1')

@section('title', 'Maintenance | Smart Locker System')
@section('page_title', 'Maintenance')

@section('content')
@php
    $prefix = request()->routeIs('staff.*') ? 'staff' : 'user';
@endphp

<div class="grid gap-5">

    {{-- Header (outside the box) --}}
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Locker maintenance</h2>
            <p class="text-sm text-gray-500 mt-0.5">Track and resolve reported locker issues.</p>
        </div>
        <a href="{{ route("$prefix.maintenance.create") }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Report Issue
        </a>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <span class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center ring-1 ring-inset ring-orange-100 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/>
                </svg>
            </span>
            <div>
                <p class="text-xs text-gray-500">Pending</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <span class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-inset ring-blue-100 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11 4.5 1.5 1.5L18 1.5M4.5 12H2m2.5 3H2m10-9-4.5 9M8 21h8a2 2 0 0 0 2-2v-2.5H6V19a2 2 0 0 0 2 2Z"/>
                </svg>
            </span>
            <div>
                <p class="text-xs text-gray-500">In progress</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <span class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center ring-1 ring-inset ring-green-100 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
            <div>
                <p class="text-xs text-gray-500">Resolved this week</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['resolved_this_week'] }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <span class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center ring-1 ring-inset ring-red-100 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                </svg>
            </span>
            <div>
                <p class="text-xs text-gray-500">Out of service</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['out_of_service'] }}</p>
            </div>
        </div>
    </div>

    {{-- Boxed section: success message, filters, table, pagination --}}
    <section class="grid gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        {{-- Success message --}}
        @if (session('success'))
            <div class="flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route("$prefix.maintenance.index") }}"
              class="grid gap-3 md:grid-cols-[1fr_180px_160px_auto] bg-gray-50 rounded-xl p-3 border border-gray-100">

            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search locker or reason..."
                       class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <select name="location_id" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Locations</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In progress</option>
                <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
            </select>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" d="m21 21-4.3-4.3"/>
                </svg>
                Search
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto border border-gray-100 rounded-xl">
            <table class="w-full text-sm text-left table-fixed">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 font-semibold w-12">#</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Locker</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Location</th>
                        <th class="px-4 py-3 font-semibold w-1/4">Reason</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Reported by</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($maintenances as $m)
                        @php
                            $badge = match ($m->status) {
                                'pending' => ['bg-orange-50 text-orange-700 ring-1 ring-inset ring-orange-200', 'bg-orange-500'],
                                'in_progress' => ['bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200', 'bg-blue-500'],
                                'resolved' => ['bg-green-50 text-green-700 ring-1 ring-inset ring-green-200', 'bg-green-500'],
                                default => ['bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200', 'bg-gray-400'],
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-4 py-3 text-gray-400">{{ $maintenances->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-inset ring-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                                            <path d="M4 12h16M9 7.5h.01M9 16.5h.01"/>
                                        </svg>
                                    </span>
                                    <span class="font-semibold text-gray-800">{{ $m->locker->locker_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $m->locker->location?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 truncate" title="{{ $m->reason }}">{{ $m->reason }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $m->reporter?->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge[0] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $badge[1] }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $m->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route("$prefix.maintenance.edit", $m) }}"
                                   title="Update"
                                   class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5v4.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V8.25A2.25 2.25 0 0 1 6.75 6H12"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-14 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                                    </svg>
                                    <span>No maintenance requests found.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $maintenances->links() }}
        </div>
    </section>

</div>
@endsection