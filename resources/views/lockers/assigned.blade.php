@extends('layouts.guest')

@section('title', 'Locker Assigned | Smart Locker System')
@section('page_title', 'Locker Assigned')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <div class="flex flex-col items-center gap-3 py-6">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-green-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Locker Assigned!</h2>
            <p class="text-sm text-gray-400">Your locker has been successfully assigned.</p>
        </div>

        <!-- Summary card -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Locker ID</p>
                    <p class="font-semibold text-gray-800">{{ $locker->name }}</p>
                </div>
            </div>
            <div class="divide-y divide-gray-50">
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Code</span>
                    <span class="text-sm font-medium text-gray-700">{{ $code ?? 'Shown on the next page' }}</span>
                </div>
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Location</span>
                    <span class="text-sm font-medium text-gray-700">{{ $locker->location->name }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <a href="{{ route('locker.code', $locker) }}"
           class="text-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
            View Locker Details
        </a>
        <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="text-center text-sm font-medium text-gray-500 hover:text-gray-700 py-2">
            Go to Dashboard
        </a>

    </section>
@endsection
