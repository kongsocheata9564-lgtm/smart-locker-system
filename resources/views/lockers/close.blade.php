@extends('layouts.guest')

@section('title', 'Close Locker | Smart Locker System')
@section('page_title', 'Close Locker')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <div class="w-full h-56 rounded-xl bg-gray-100 overflow-hidden">
            {{-- <img src="/path/to/backpack-in-locker.jpg" class="w-full h-full object-cover"> --}}
        </div>

        <p class="text-center text-sm text-gray-500">
            Make sure your belongings are safe and the locker door is closed.
        </p>

        <form method="POST" action="{{ route('locker.close.store', $locker) }}">
            @csrf
            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-3 rounded-xl transition">
                Close Locker
            </button>
        </form>

    </section>
@endsection