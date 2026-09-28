@extends('layouts.guest')

@section('title', $locker->name . ' | Release Locker')
@section('page_title', 'Release Locker')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $locker->name }}</p>
                    <p class="text-sm text-gray-400">{{ $locker->location->name }}</p>
                </div>
            </div>

            <div class="divide-y divide-gray-50">
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Type</span>
                    <span class="text-sm font-medium text-gray-700">{{ ucfirst($locker->type) }}</span>
                </div>
                <div class="flex justify-between py-2.5">
                    <span class="text-sm text-gray-400">Started</span>
                    <span class="text-sm font-medium text-gray-700">{{ $usage->start_time->format('M j, Y g:i A') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-sm text-gray-600">Make sure your belongings are safe and the locker door is closed before releasing it.</p>
        </div>

        <form method="POST" action="{{ route('locker.release.store', $locker) }}" class="grid gap-3">
            @csrf

            @if ($isStaff)
                <p class="text-sm text-gray-500">Staff can release this locker without the user code.</p>
            @else
                <label for="code" class="text-sm font-semibold text-gray-700">Enter your locker code</label>
                <input id="code" name="code" type="text" maxlength="6" required autocomplete="off"
                       class="w-full text-center text-2xl tracking-widest uppercase px-4 py-3 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-blue-200">
                @error('code')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            @endif

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
                Release Locker
            </button>
        </form>

        <a href="{{ route('locker.show', $locker) }}" class="text-center text-sm font-medium text-gray-500 hover:text-gray-700 py-2">
            Back to Locker
        </a>
    </section>
@endsection
