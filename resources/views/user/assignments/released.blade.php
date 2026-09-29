@extends('layouts.user')

@section('title', 'Locker Released | Smart Locker System')
@section('page_title', 'Locker Released')

@section('content')

<div class="text-center pt-6 pb-6">
    <div class="w-16 h-16 mx-auto rounded-full bg-green-500 flex items-center justify-center mb-4">
        <i class="bi bi-check-lg text-4xl text-white"></i>
    </div>
    <h2 class="text-xl font-bold text-[#123a6b]">Locker Released!</h2>
    <p class="text-xs text-gray-500 mt-1">The locker is now available for other users.</p>
</div>

<div class="flex items-center justify-between bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-[#eaf1fb] flex items-center justify-center">
            <i class="bi bi-box-seam text-xl text-[#1e5fc4]"></i>
        </div>
        <div>
            <p class="text-lg font-extrabold text-[#123a6b]">{{ $assignment->locker->locker_name }}</p>
            <p class="text-xs text-gray-500">{{ $assignment->locker->location->name ?? '-' }}</p>
        </div>
    </div>
    <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Available</span>
</div>

<a href="{{ route('user.index') }}"
   class="block text-center w-full py-3.5 rounded-full bg-[#123a6b] text-white font-bold text-sm shadow-lg no-underline mb-3">Back to Dashboard</a>
<a href="{{ route('user.usage-history.index') }}"
   class="block text-center w-full py-3.5 rounded-full bg-white border border-gray-200 text-[#123a6b] font-bold text-sm no-underline">View History</a>

@endsection