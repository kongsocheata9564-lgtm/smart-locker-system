@extends('layouts.guest')

@section('title', 'Profile | Smart Locker System')
@section('page_title', 'Profile')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <!-- Profile header -->
        <div class="flex flex-col items-center gap-2 py-4">
            <div class="w-20 h-20 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 text-2xl font-bold">
                DC
            </div>
            <h2 class="text-lg font-bold text-gray-800">Dara Chan</h2>
            <p class="text-sm text-gray-400">dara.chan@email.com</p>
        </div>

        <!-- Stats row -->
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
                <p class="text-xl font-semibold text-gray-800">18</p>
                <p class="text-xs text-gray-400">Total Check-ins</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
                <p class="text-xl font-semibold text-gray-800">1</p>
                <p class="text-xs text-gray-400">Active Locker</p>
            </div>
        </div>

        <!-- Menu list -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm divide-y divide-gray-50">

            <a href="#" class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                </div>
                <span class="flex-1 text-sm text-gray-700">Edit Profile</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <span class="flex-1 text-sm text-gray-700">Notifications</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <span class="flex-1 text-sm text-gray-700">Help &amp; Support</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-white border border-red-100 text-red-500 text-sm font-medium py-3 rounded-xl hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15m-3 0l-3-3m0 0l3-3m-3 3H15" />
                </svg>
                Logout
            </button>
        </form>

    </section>
@endsection