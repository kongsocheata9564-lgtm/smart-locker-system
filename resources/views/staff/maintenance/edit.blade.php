@extends('layouts.app1')

@section('title', 'Update Maintenance | Smart Locker System')
@section('page_title', 'Update Maintenance')

@section('content')
@php
    $prefix = request()->routeIs('staff.*') ? 'staff' : 'user';
@endphp

<div class="grid gap-5">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $maintenance->locker->locker_name }}</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $maintenance->reason }}</p>
    </div>

    <section class="grid gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-lg">
        <form method="POST" action="{{ route("$prefix.maintenance.update", $maintenance) }}" class="grid gap-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                <select name="status"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending" @selected($maintenance->status === 'pending')>Pending</option>
                    <option value="in_progress" @selected($maintenance->status === 'in_progress')>In progress</option>
                    <option value="resolved" @selected($maintenance->status === 'resolved')>Resolved</option>
                </select>
            </div>

            @if ($maintenance->status === 'resolved')
                <div class="flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 text-xs px-3 py-2">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Resolved by {{ $maintenance->solver->name ?? '—' }} on {{ $maintenance->solve_at?->format('M j, Y') }}
                </div>
            @endif

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                    Save changes
                </button>
                <a href="{{ route("$prefix.maintenance.index") }}"
                   class="text-sm font-semibold text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection