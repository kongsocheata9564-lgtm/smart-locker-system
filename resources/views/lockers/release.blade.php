@extends('layouts.guest')

@section('title', 'Locker Released | Smart Locker System')
@section('page_title', 'Locker Released')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <div class="flex flex-col items-center gap-3 py-6">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-green-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Locker Released!</h2>
            <p class="text-sm text-gray-400 text-center">The locker is now available for other users.</p>
        </div>

        <div class="flex items-center gap-4 bg-white border border-green-100 rounded-xl p-4 shadow-sm">
            <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="3" width="16" height="18" rx="2" />
                    <path stroke-linecap="round" d="M15 11v2" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">L-001</p>
                <span class="text-xs font-medium text-green-500">Available</span>
            </div>
        </div>

        {{-- TODO: point at your dashboard route once built --}}
        <a href="{{ route('user.index') }}" class="text-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
            Back to Dashboard
        </a>

    </section>
@endsection