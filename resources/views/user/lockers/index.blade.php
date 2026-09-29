@extends('layouts.user')

@section('title', 'Lockers | Smart Locker System')
@section('page_title', 'Lockers')
@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">My Lockers</h2>
                <p class="text-sm text-gray-400">Your current locker assignments.</p>
            </div>
            <span class="text-sm text-gray-500">{{ $lockers->count() }} total</span>
        </div>

        <div class="grid gap-3">
            @forelse ($lockers as $locker)
                <div class="flex items-center justify-between gap-4 border border-gray-100 rounded-xl p-4">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $locker->name }}</p>
                        <p class="text-sm text-gray-400">{{ $locker->location->name ?? 'Unknown location' }}</p>
                    </div>
                    <a href="{{ route('locker.release', $locker) }}"
                       class="text-sm font-medium text-blue-500 hover:text-blue-600">
                        View details
                    </a>
                </div>
            @empty
                <p class="rounded-xl bg-gray-50 px-4 py-8 text-center text-sm text-gray-400">
                    You do not have an active locker assignment.
                </p>
            @endforelse
        </div>
    </section>
@endsection
