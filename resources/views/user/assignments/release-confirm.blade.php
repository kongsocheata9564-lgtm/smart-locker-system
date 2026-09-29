@extends('layouts.user')

@section('title', 'Confirm Release | Smart Locker System')
@section('page_title', 'Confirm Release')
@section('back', route('user.assignments.show', $assignment))

@section('content')

<div class="text-center pt-2 pb-5">
    <div class="w-24 h-24 mx-auto rounded-3xl bg-[#eaf1fb] flex items-center justify-center mb-3">
        <i class="bi bi-box-seam text-5xl text-[#1e5fc4]"></i>
    </div>
    <h2 class="text-3xl font-extrabold text-[#123a6b]">{{ $assignment->locker->locker_name }}</h2>
    <p class="text-xs text-gray-500 mt-1">{{ $assignment->locker->location->name ?? '-' }}</p>
</div>

<div class="flex items-start gap-2 bg-orange-50 text-orange-700 text-xs rounded-xl px-3 py-2.5 mb-5">
    <i class="bi bi-exclamation-circle mt-0.5"></i>
    <span>Take all your belongings first. Your code stops working after release.</span>
</div>

<form method="POST" action="{{ route('user.assignments.release', $assignment) }}" class="grid grid-cols-2 gap-3">
    @csrf
    <a href="{{ route('user.assignments.show', $assignment) }}"
       class="text-center py-3.5 rounded-full bg-white border border-gray-200 text-gray-600 font-bold text-sm no-underline">Cancel</a>
    <button type="submit" class="py-3.5 rounded-full bg-[#1e5fc4] text-white font-bold text-sm shadow-lg">Confirm</button>
</form>

@endsection