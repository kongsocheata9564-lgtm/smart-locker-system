@extends('layouts.app1')

@section('title', 'Report Issue | Smart Locker System')
@section('page_title', 'Report Issue')

@section('content')
@php
    $prefix = request()->routeIs('staff.*') ? 'staff' : 'user';
@endphp

<div class="grid gap-5">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Report a maintenance issue</h2>
        <p class="text-sm text-gray-500 mt-0.5">Log a problem with a locker so staff can act on it.</p>
    </div>

    <section class="grid gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-lg">
        <form method="POST" action="{{ route("$prefix.maintenance.store") }}" class="grid gap-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Locker</label>
                <select name="locker_id"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('locker_id') border-red-300 @else border-gray-200 @enderror"
                        required>
                    <option value="">Select a locker</option>
                    @foreach ($lockers as $locker)
                        <option value="{{ $locker->id }}" @selected(old('locker_id') == $locker->id)>
                            {{ $locker->name }}
                        </option>
                    @endforeach
                </select>
                @error('locker_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Reason</label>
                <input type="text" name="reason" value="{{ old('reason') }}"
                       placeholder="e.g. Door lock jammed"
                       class="w-full border rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reason') border-red-300 @else border-gray-200 @enderror"
                       required>
                @error('reason') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                    Report issue
                </button>
                <a href="{{ route("$prefix.maintenance.index") }}"
                   class="text-sm font-semibold text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection