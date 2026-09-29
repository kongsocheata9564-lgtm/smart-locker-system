@extends('layouts.app1')

@section('title', 'Add Location | Smart Locker System')

@section('page_title', 'Add Location')

@section('content')

@php
    $prefix = request()->routeIs('staff.*') ? 'staff' : 'user';
@endphp

<div class="grid gap-5 max-w-2xl">

    {{-- Header --}}
    <div class="flex items-center gap-3">

        <a
            href="{{ route($prefix . '.locations.index') }}"
            class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors"
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
                    d="M15 19l-7-7 7-7"
                />
            </svg>

        </a>

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Add Location
            </h2>

            <p class="text-sm text-gray-500 mt-0.5">
                Create a new locker location.
            </p>

        </div>

    </div>

    {{-- Form --}}
    <section class="grid gap-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <form
            method="POST"
            action="{{ route($prefix . '.locations.store') }}"
            class="grid gap-5"
        >

            @csrf

            {{-- Location Name --}}
            <div class="grid gap-1.5">

                <label
                    for="name"
                    class="text-sm font-medium text-gray-700"
                >
                    Location Name
                </label>

                <div class="relative">

                    <svg
                        class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
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

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Central Library"
                        class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-300 @enderror"
                    >

                </div>

                @error('name')
                    <p class="text-xs text-red-600 flex items-center gap-1">

                        <svg
                            class="w-3.5 h-3.5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path
                                stroke-linecap="round"
                                d="M12 8v4m0 4h.01"
                            />
                        </svg>

                        {{ $message }}

                    </p>
                @enderror

            </div>

            {{-- Address --}}
            <div class="grid gap-1.5">

                <label
                    for="address"
                    class="text-sm font-medium text-gray-700"
                >
                    Address
                </label>

                <div class="relative">

                    <svg
                        class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
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
                            d="M5 9.5V21h14V9.5"
                        />
                    </svg>

                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address') }}"
                        placeholder="Phnom Penh"
                        class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-300 @enderror"
                    >

                </div>

                @error('address')
                    <p class="text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Type + Status --}}
            <div class="grid gap-5 md:grid-cols-2">

                {{-- Type --}}
                <div class="grid gap-1.5">

                    <label
                        for="type"
                        class="text-sm font-medium text-gray-700"
                    >
                        Type
                    </label>

                    <select
                        id="type"
                        name="type"
                        class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-300 @enderror"
                    >

                        <option value="">
                            Select type
                        </option>

                        <option value="library" @selected(old('type') === 'library')>
                            Library
                        </option>

                        <option value="shopping_mall" @selected(old('type') === 'shopping_mall')>
                            Shopping Mall
                        </option>

                        <option value="sports_center" @selected(old('type') === 'sports_center')>
                            Sports Center
                        </option>

                        <option value="building" @selected(old('type') === 'building')>
                            Building
                        </option>

                        <option value="public_place" @selected(old('type') === 'public_place')>
                            Public Place
                        </option>

                    </select>

                    @error('type')
                        <p class="text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Status --}}
                <div class="grid gap-1.5">

                    <label
                        for="status"
                        class="text-sm font-medium text-gray-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-300 @enderror"
                    >

                        <option value="active" @selected(old('status', 'active') === 'active')>
                            Active
                        </option>

                        <option value="inactive" @selected(old('status') === 'inactive')>
                            Inactive
                        </option>

                    </select>

                    @error('status')
                        <p class="text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- Map --}}
            <div class="grid gap-1.5">

                <label
                    for="map"
                    class="text-sm font-medium text-gray-700"
                >
                    Map URL
                </label>

                <div class="relative">

                    <svg
                        class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 20l-5-2.5V5l5 2.5L15 5l5 2.5v12.5L15 17l-6 3Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 7.5V20M15 5v12"
                        />
                    </svg>

                    <input
                        type="text"
                        id="map"
                        name="map"
                        value="{{ old('map') }}"
                        placeholder="https://maps.google.com/..."
                        class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('map') border-red-300 @enderror"
                    >

                </div>

                <p class="text-xs text-gray-400">
                    Optional. Add a Google Maps or location URL.
                </p>

                @error('map')
                    <p class="text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-1">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors"
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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Save Location

                </button>

                <a
                    href="{{ route($prefix . '.locations.index') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-800 px-3 py-2.5 transition-colors"
                >
                    Cancel
                </a>

            </div>

        </form>

    </section>

</div>

@endsection