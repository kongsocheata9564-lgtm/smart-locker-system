@extends('layouts.guest')

@section('title', 'Your Locker Code | Smart Locker System')
@section('page_title', 'Locker Code')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <!-- Code card -->
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">Your Locker Code</p>
            </div>

            @if ($code)
                <p class="text-3xl font-bold text-blue-900 tracking-wider mb-4">{{ $code }}</p>
            @else
                <p class="text-sm text-orange-600 mb-4">
                    Your code is no longer shown on this device. Please ask staff for help if you forgot it.
                </p>
            @endif

            <div class="divide-y divide-gray-50">
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Locker ID</span>
                    <span class="text-sm font-medium text-gray-700">{{ $locker->name }}</span>
                </div>
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Location</span>
                    <span class="text-sm font-medium text-gray-700">{{ $locker->location->name }}</span>
                </div>
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Type</span>
                    <span class="text-sm font-medium text-gray-700">{{ ucfirst($locker->type) }}</span>
                </div>
            </div>
        </div>

        <!-- Warning note -->
        <div class="flex items-start gap-2 bg-blue-50 text-blue-700 text-xs rounded-lg p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <span>Keep this code safe. You will need it to release the locker.</span>
        </div>

        <!-- Action -->
        <a href="{{ route('locker.close', $locker) }}"
           class="text-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
            OK
        </a>

    </section>
@endsection