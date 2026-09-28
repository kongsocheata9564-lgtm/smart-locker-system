@extends('layouts.app')

@section('content')
<section class="grid gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Lockers</h2>
            <p class="text-sm text-gray-500 mt-0.5">Manage all lockers across locations.</p>
        </div>
        <a href="{{ route('lockers.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Locker
        </a>
    </div>

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
    <form method="GET" action="{{ route('lockers.index') }}"
          class="grid gap-3 md:grid-cols-[1fr_180px_160px_auto] bg-gray-50 rounded-xl p-3 border border-gray-100">

        <div class="relative">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <path stroke-linecap="round" d="m21 21-4.3-4.3"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search locker name..."
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
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
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
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 font-semibold">#</th>
                    <th class="px-4 py-3 font-semibold">Locker #</th>
                    <th class="px-4 py-3 font-semibold">Location</th>
                    <th class="px-4 py-3 font-semibold">Type</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Last Used</th>
                    <th class="px-4 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($lockers as $locker)
                    @php
                        $badge = match ($locker->status) {
                            'available' => ['bg-green-50 text-green-700 ring-1 ring-inset ring-green-200', 'bg-green-500'],
                            'in_use' => ['bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200', 'bg-blue-500'],
                            'maintenance' => ['bg-orange-50 text-orange-700 ring-1 ring-inset ring-orange-200', 'bg-orange-500'],
                            default => ['bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200', 'bg-gray-400'],
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-4 py-3 text-gray-400">{{ $lockers->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-inset ring-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                                        <path d="M4 12h16M9 7.5h.01M9 16.5h.01"/>
                                    </svg>
                                </span>
                                <span class="font-semibold text-gray-800">{{ $locker->locker_name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $locker->location?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 capitalize">{{ $locker->type }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge[0] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $badge[1] }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $locker->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $locker->updated_at?->diffForHumans() ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('lockers.edit', $locker) }}"
                                   title="Edit"
                                   class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5v4.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V8.25A2.25 2.25 0 0 1 6.75 6H12"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('lockers.destroy', $locker) }}"
                                      onsubmit="return confirm('Delete this locker?')"
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
                                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                                    <path d="M4 12h16M9 7.5h.01M9 16.5h.01"/>
                                </svg>
                                <span>No lockers found.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $lockers->links() }}
    </div>
</section>
@endsection