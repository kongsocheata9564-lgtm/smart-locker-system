@extends('layouts.guest')

@section('title', 'Locker In Use | Smart Locker System')
@section('page_title', 'You\'re All Set')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <div class="flex flex-col items-center gap-3 py-6">
            <div class="relative w-16 h-16 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="3" width="16" height="18" rx="2" />
                    <path stroke-linecap="round" d="M15 11v2" />
                </svg>
                <span class="absolute -top-1.5 -right-1.5 w-6 h-6 flex items-center justify-center rounded-full bg-green-500 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </span>
            </div>
            <h2 class="text-lg font-bold text-gray-800">You're all set!</h2>
            <p class="text-sm text-gray-400 text-center">Your locker is now in use.<br>Keep your code for release.</p>
        </div>

        <a href="{{ route('locker.release', $locker) }}"
           class="text-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
            View Locker Details
        </a>
        {{-- TODO: point at your dashboard route once built --}}
        <a href="#" class="text-center text-sm font-medium text-gray-500 hover:text-gray-700 py-2">
            Go to Dashboard
        </a>

    </section>
@endsection