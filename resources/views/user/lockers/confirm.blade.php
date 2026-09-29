@extends('layouts.user')

@section('title', 'Confirm Selection | Smart Locker System')
@section('page_title', 'Confirm Selection')
@section('back', route('user.locations.lockers', $locker->location_id))

@section('content')

<div class="text-center pt-2 pb-5">
    <div class="w-24 h-24 mx-auto rounded-3xl bg-[#eaf1fb] flex items-center justify-center mb-3">
        <i class="bi bi-box-seam text-5xl text-[#1e5fc4]"></i>
    </div>
    <h2 class="text-3xl font-extrabold text-[#123a6b]">{{ $locker->locker_name }}</h2>
    <span class="inline-flex items-center gap-1.5 mt-2 bg-green-50 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Available
    </span>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100 mb-4">
    <div class="px-4 py-3">
        <p class="text-[10px] font-semibold text-gray-400 uppercase">Location</p>
        <p class="text-sm font-bold text-gray-900">{{ $locker->location->name ?? '-' }}</p>
    </div>
    <div class="px-4 py-3">
        <p class="text-[10px] font-semibold text-gray-400 uppercase">Address</p>
        <p class="text-sm font-bold text-gray-900">{{ $locker->location->address ?? '-' }}</p>
    </div>
    <div class="px-4 py-3">
        <p class="text-[10px] font-semibold text-gray-400 uppercase">Type</p>
        <p class="text-sm font-bold text-gray-900">{{ ucfirst($locker->type) }}</p>
    </div>
</div>

<div class="flex items-start gap-2 bg-[#eaf1fb] text-[#123a6b] text-xs rounded-xl px-3 py-2.5 mb-5">
    <i class="bi bi-info-circle mt-0.5"></i>
    <span>Code will be shown after assignment.</span>
</div>

<form method="POST" action="{{ route('user.lockers.select', $locker) }}">
    @csrf
    <button type="submit" class="w-full py-3.5 rounded-full bg-[#1e5fc4] text-white font-bold text-sm shadow-lg active:scale-95 transition">
        Confirm Locker
    </button>
</form>

@endsection