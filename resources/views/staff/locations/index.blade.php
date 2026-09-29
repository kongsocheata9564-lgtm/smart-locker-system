@extends('layouts.user')

@section('title', 'Locations | Smart Locker System')

@section('page_title', 'Locations')

@section('content')

@php
    $prefix = request()->routeIs('staff.*') ? 'staff' : 'user';
@endphp

<div class="grid gap-5">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3 flex-wrap">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Locations
            </h2>

            <p class="text-sm text-gray-500 mt-0.5">
                Manage all locker locations.
            </p>
        </div>

        @if($prefix === 'staff')
            <x-btn :href="route($prefix . '.locations.create')">

                <x-slot:icon>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </x-slot:icon>

                Add Location
            </x-btn>
        @endif

    </div>

    {{-- Main Box --}}
    <section class="grid gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">

                <svg
                    class="w-4 h-4 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                {{ session('success') }}

            </div>
        @endif

        {{-- Search --}}
        <form
            method="GET"
            action="{{ route($prefix . '.locations.index') }}"
            class="grid gap-3 md:grid-cols-[1fr_auto] bg-gray-50 rounded-xl p-3 border border-gray-100"
        >

            <x-search-input
                name="search"
                placeholder="Search location..."
            />

            <x-btn type="submit">

                <x-slot:icon>
                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <path
                        stroke-linecap="round"
                        d="m21 21-4.3-4.3"
                    />
                </x-slot:icon>

                Search

            </x-btn>

        </form>

        {{-- Table --}}
        <div class="overflow-x-auto border border-gray-100 rounded-xl">

            <table class="w-full text-sm text-left table-fixed">

                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">

                    <tr>

                        <th class="px-4 py-3 font-semibold w-12">
                            #
                        </th>

                        <th class="px-4 py-3 font-semibold w-1/4">
                            Location
                        </th>

                        <th class="px-4 py-3 font-semibold w-1/4">
                            Address
                        </th>

                        <th class="px-4 py-3 font-semibold w-1/6">
                            Type
                        </th>

                        <th class="px-4 py-3 font-semibold w-1/6">
                            Status
                        </th>

                        @if($prefix === 'staff')
                            <th class="px-4 py-3 font-semibold text-right">
                                Actions
                            </th>
                        @endif

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($locations as $location)

                        @php
                            $badge = match ($location->status) {
                                'active' => [
                                    'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200',
                                    'bg-green-500'
                                ],

                                'inactive' => [
                                    'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200',
                                    'bg-gray-400'
                                ],

                                default => [
                                    'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200',
                                    'bg-gray-400'
                                ],
                            };
                        @endphp

                        <tr class="hover:bg-gray-50/70 transition-colors">

                            {{-- Number --}}
                            <td class="px-4 py-3 text-gray-400">
                                {{ $locations->firstItem() + $loop->index }}
                            </td>

                            {{-- Location --}}
                            <td class="px-4 py-3">

                                <div class="flex items-center gap-3">

                                    <span class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-inset ring-blue-100">

                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.75"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="9"
                                                r="2.5"
                                            />
                                        </svg>

                                    </span>

                                    <span class="font-semibold text-gray-800">
                                        {{ $location->name }}
                                    </span>

                                </div>

                            </td>

                            {{-- Address --}}
                            <td class="px-4 py-3 text-gray-600">

                                <div class="flex items-center gap-2">

                                    <svg
                                        class="w-4 h-4 text-gray-400 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.75"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 10.5 12 3l9 7.5"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 9.5V21h14V9.5M9 21v-6h6v6"
                                        />
                                    </svg>

                                    <span>
                                        {{ $location->address }}
                                    </span>

                                </div>

                            </td>

                            {{-- Type --}}
                            <td class="px-4 py-3 text-gray-600">

                                {{ ucwords(str_replace('_', ' ', $location->type)) }}

                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge[0] }}">

                                    <span class="w-1.5 h-1.5 rounded-full {{ $badge[1] }}"></span>

                                    {{ ucfirst($location->status) }}

                                </span>

                            </td>

                            {{-- Actions --}}
                            @if($prefix === 'staff')

                                <td class="px-4 py-3 text-right">

                                    <div class="inline-flex items-center gap-2">

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route($prefix . '.locations.edit', $location) }}"
                                            title="Edit"
                                            class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors"
                                        >

                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 20h9"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L8 18l-4 1 1-4L16.5 3.5Z"
                                                />
                                            </svg>

                                        </a>

                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route($prefix . '.locations.destroy', $location) }}"
                                            onsubmit="return confirm('Delete this location?')"
                                            class="inline-flex m-0"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Delete"
                                                class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-colors"
                                            >

                                                <svg
                                                    class="w-4 h-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3 6h18"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M8 6V4h8v2"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19 6l-1 14H6L5 6"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M10 11v5M14 11v5"
                                                    />
                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $prefix === 'staff' ? 6 : 5 }}"
                                class="px-4 py-14 text-center text-gray-400"
                            >

                                <div class="flex flex-col items-center gap-2">

                                    <svg
                                        class="w-8 h-8 text-gray-300"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="9"
                                            r="2.5"
                                        />
                                    </svg>

                                    <span>
                                        No locations found.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($locations->hasPages())
            <div>
                {{ $locations->links() }}
            </div>
        @endif

    </section>

</div>

@endsection