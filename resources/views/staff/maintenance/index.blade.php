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
            <x-btn :href="route($prefix . '.maintenance.create')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </x-slot:icon>
            Report Issue
        </x-btn>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card label="Pending" :value="$stats['pending']" color="orange">
            <x-slot:icon>
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="In progress" :value="$stats['in_progress']" color="blue">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="m11 4.5 1.5 1.5L18 1.5M4.5 12H2m2.5 3H2m10-9-4.5 9M8 21h8a2 2 0 0 0 2-2v-2.5H6V19a2 2 0 0 0 2 2Z"/>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Resolved this week" :value="$stats['resolved_this_week']" color="green">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Out of service" :value="$stats['out_of_service']" color="red">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
            </x-slot:icon>
        </x-stat-card>
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

            <x-search-input name="search" placeholder="Search locker or reason..." />

            <x-filter-select name="location_id" placeholder="All Locations">
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>
                        {{ $location->name }}
                    </option>
                @endforeach
            </x-filter-select>

            <x-filter-select name="status" placeholder="All Status">
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In progress</option>
                <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
            </x-filter-select>

            <x-btn type="submit">
                <x-slot:icon>
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" d="m21 21-4.3-4.3"/>
                </x-slot:icon>
                Search
            </x-btn>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto border border-gray-100 rounded-xl">
            <table class="w-full text-sm text-left table-fixed">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 font-semibold w-12">#</th>
                        <th class="px-4 py-3 font-semibold w-1/5">Locker</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Location</th>
                        <th class="px-4 py-3 font-semibold w-1/4">Reason</th>
                        <th class="px-4 py-3 font-semibold w-1/6">Reported by</th>
                        <th class="px-4 py-3 font-semibold w-32">Status</th>
                        <th class="px-4 py-3 font-semibold text-right w-28">Actions</th>
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
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route("$prefix.maintenance.edit", $m) }}"
                                       title="Update"
                                       class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5v4.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V8.25A2.25 2.25 0 0 1 6.75 6H12"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route("$prefix.maintenance.destroy", $m) }}"
                                          onsubmit="return confirm('Delete this maintenance request?')"
                                          class="inline-flex m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                                class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
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