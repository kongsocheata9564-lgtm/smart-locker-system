@extends('layouts.app')

@section('content')
<section class="grid gap-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('lockers.index') }}"
           class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Locker</h2>
            <p class="text-sm text-gray-500 mt-0.5">Update locker details.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('lockers.update', $locker) }}" class="grid gap-5">
        @csrf
        @method('PUT')

        {{-- Locker Name --}}
        <div class="grid gap-1.5">
            <label for="locker_name" class="text-sm font-medium text-gray-700">Locker Name</label>
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                    <path d="M4 12h16M9 7.5h.01M9 16.5h.01"/>
                </svg>
                <input type="text" id="locker_name" name="locker_name" value="{{ old('locker_name', $locker->locker_name) }}"
                       class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('locker_name') border-red-300 @enderror">
            </div>
            @error('locker_name') <p class="text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
                {{ $message }}
            </p> @enderror
        </div>

        {{-- Location --}}
        <div class="grid gap-1.5">
            <label for="location_id" class="text-sm font-medium text-gray-700">Location</label>
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                </svg>
                <select id="location_id" name="location_id"
                        class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location_id') border-red-300 @enderror">
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id', $locker->location_id) == $location->id)>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('location_id') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Type + Status --}}
        <div class="grid gap-5 md:grid-cols-2">
            <div class="grid gap-1.5">
                <label for="type" class="text-sm font-medium text-gray-700">Type</label>
                <select id="type" name="type"
                        class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-300 @enderror">
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(old('type', $locker->type) === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                @error('type') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-1.5">
                <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                        class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-300 @enderror">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $locker->status) === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
                @error('status') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="grid gap-1.5">
            <label for="password" class="text-sm font-medium text-gray-700">New Password</label>
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="4.5" y="10.5" width="15" height="9" rx="1.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V7a4 4 0 0 1 8 0v3.5"/>
                </svg>
                <input type="password" id="password" name="password" placeholder="Leave empty to keep current password"
                       class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-300 @enderror">
            </div>
            @error('password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-1">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Update Locker
            </button>
            <a href="{{ route('lockers.index') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-800 px-3 py-2.5 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</section>
@endsection