@extends('layouts.guest')

@section('title', 'L-001 | Smart Locker System')
@section('page_title', 'Locker Detail')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <!-- Locker card -->
        <div class="flex flex-col items-center gap-3 bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
            <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="3" width="16" height="18" rx="2" />
                    <path stroke-linecap="round" d="M15 11v2" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-800">L-001</h2>
            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 text-xs font-medium px-3 py-1 rounded-full">
                <span class="w-2 h-2 rounded-full bg-green-500"></span> Available
            </span>
        </div>

        <!-- Details -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm divide-y divide-gray-50">
            <div class="flex justify-between py-2.5">
                <span class="text-sm text-gray-400">Location</span>
                <span class="text-sm font-medium text-gray-700">ABC Mall</span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-sm text-gray-400">Floor</span>
                <span class="text-sm font-medium text-gray-700">1st Floor</span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-sm text-gray-400">Type</span>
                <span class="text-sm font-medium text-gray-700">Standard (Large)</span>
            </div>
        </div>

        <!-- Actions -->
        <button type="button" onclick="document.getElementById('confirm-locker-modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
            Confirm Locker
        </button>
        <a href="{{ url()->previous() }}" class="text-center text-sm font-medium text-gray-500 hover:text-gray-700 py-2">
            Back
        </a>

    </section>

    <!-- Confirm Locker modal -->
    <div id="confirm-locker-modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm p-6 relative">

            <button type="button" onclick="document.getElementById('confirm-locker-modal').classList.add('hidden')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-base font-semibold text-gray-800 mb-4">Confirm Locker</h3>

            <div class="flex flex-col items-center gap-2 mb-4">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <p class="font-bold text-gray-800">L-001</p>
                <p class="text-xs text-gray-400">ABC Mall - 1st Floor</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-3 mb-2">
                <p class="text-sm text-gray-600">Type: Standard (Large)</p>
            </div>
            <p class="text-xs text-gray-400 mb-5">Code will be shown after assignment.</p>

            <div class="flex gap-3">
    <button type="button" onclick="document.getElementById('confirm-locker-modal').classList.add('hidden')"
            class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">
        Cancel
    </button>

    <form method="POST" action="{{ route('locker.assign', 'L-001') }}" class="flex-1">
        @csrf
        <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg">
            Confirm
        </button>
    </form>
</div>

        </div>
    </div>
@endsection