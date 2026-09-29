@extends('layouts.user')

@section('title', 'Locker Assigned | Smart Locker System')
@section('page_title', 'Locker Assigned')

@section('content')

<div class="text-center pt-2 pb-4">
    <div class="w-14 h-14 mx-auto rounded-full bg-green-500 flex items-center justify-center mb-3">
        <i class="bi bi-check-lg text-3xl text-white"></i>
    </div>
    <h2 class="text-xl font-bold text-[#123a6b]">Locker Assigned!</h2>
    <p class="text-xs text-gray-500">Use the code below to open your locker.</p>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-[#eaf1fb] flex items-center justify-center">
                <i class="bi bi-box-seam text-xl text-[#1e5fc4]"></i>
            </div>
            <div>
                <p class="text-lg font-extrabold text-[#123a6b]">{{ $assignment->locker->locker_name }}</p>
                <p class="text-xs text-gray-500">{{ $assignment->locker->location->name ?? '-' }}</p>
            </div>
        </div>
        <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full">In Use</span>
    </div>

    <div class="rounded-xl bg-[#eaf1fb] py-4 text-center">
        <p class="text-[10px] font-semibold text-gray-500 uppercase">One-time code</p>
        <p class="text-3xl font-mono font-bold tracking-[0.3em] text-[#123a6b] mt-1">{{ $assignment->one_time_password }}</p>
    </div>

    <p class="text-[11px] text-gray-400 text-center mt-3">Started {{ $assignment->start_time?->format('d M Y, h:i A') }}</p>
</div>

<a href="{{ route('user.assignments.release.confirm', $assignment) }}"
   class="block text-center w-full py-3.5 rounded-full bg-red-500 text-white font-bold text-sm shadow-lg no-underline mb-3">
    <i class="bi bi-unlock"></i> Release Locker
</a>
<a href="{{ route('user.index') }}"
   class="block text-center w-full py-3.5 rounded-full bg-white border border-gray-200 text-[#123a6b] font-bold text-sm no-underline">
    Back to Dashboard
</a>

@endsection