@extends('layouts.user')

@section('title', 'My Locker | Smart Locker System')
@section('page_title', 'My Locker')

@section('content')

@forelse ($myActive as $u)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-[#eaf1fb] flex items-center justify-center">
                    <i class="bi bi-box-seam text-xl text-[#1e5fc4]"></i>
                </div>
                <div>
                    <p class="text-lg font-extrabold text-[#123a6b]">{{ $u->locker->name }}</p>
                    <p class="text-xs text-gray-500">
                        In Use
                        <span class="ml-1 text-[10px] font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded-full">In Use</span>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-gray-400">One-time use</p>
                <p class="text-sm font-mono font-bold text-[#123a6b]">Code: {{ $u->one_time_password }}</p>
            </div>
        </div>

        <p class="text-[11px] text-gray-400 mt-3">
            {{ $u->locker->location->name ?? '-' }} · Started {{ $u->start_time?->format('d M, h:i A') }}
        </p>
    </div>

    <a href="{{ route('locker.release', $u->locker) }}"
       class="block text-center w-full py-3.5 rounded-full bg-red-500 text-white font-bold text-sm shadow-lg no-underline mb-3">
        <i class="bi bi-unlock"></i> Release Locker
    </a>
@empty
    <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center mt-4">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-[#eaf1fb] flex items-center justify-center mb-3">
            <i class="bi bi-box-seam text-3xl text-[#1e5fc4]"></i>
        </div>
        <h2 class="text-base font-bold text-[#123a6b]">No locker in use</h2>
        <p class="text-xs text-gray-500 mt-1 mb-5">Find a location and pick an available locker.</p>
        <a href="{{ route('user.locations.lockers') }}"
           class="inline-block px-8 py-3 rounded-full bg-[#1e5fc4] text-white text-sm font-bold no-underline">
            Find a Locker
        </a>
    </div>
@endforelse

<a href="{{ route('user.index') }}"
   class="block text-center w-full py-3.5 rounded-full bg-white border border-gray-200 text-[#123a6b] font-bold text-sm no-underline mt-3">
    Back to Dashboard
</a>

@endsection
