@extends('layouts.guest')

@section('title', 'Activity | Smart Locker System')
@section('page_title', 'Activity')

@section('content')
    <section class="grid gap-4 max-w-md mx-auto p-4">

        <!-- Page header -->
        <div>
            <h2 class="text-xl font-bold text-blue-900">Activity</h2>
            <p class="text-sm text-gray-400">Your locker check-ins and releases.</p>
        </div>

        <!-- Activity list -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm divide-y divide-gray-50">

            <!-- Item -->
            <div class="flex items-start gap-3 px-4 py-3.5">
                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">Checked in to <span class="font-medium">L-001</span></p>
                    <p class="text-xs text-gray-400">ABC Mall</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">Today, 2:14 PM</span>
            </div>

            <!-- Item -->
            <div class="flex items-start gap-3 px-4 py-3.5">
                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">Released <span class="font-medium">L-004</span></p>
                    <p class="text-xs text-gray-400">National Library</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">Yesterday, 5:40 PM</span>
            </div>

            <!-- Item -->
            <div class="flex items-start gap-3 px-4 py-3.5">
                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">Checked in to <span class="font-medium">L-004</span></p>
                    <p class="text-xs text-gray-400">National Library</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">Yesterday, 1:05 PM</span>
            </div>

            <!-- Item -->
            <div class="flex items-start gap-3 px-4 py-3.5">
                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-green-50 text-green-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">Released <span class="font-medium">L-009</span></p>
                    <p class="text-xs text-gray-400">Sports Center</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">3 days ago</span>
            </div>

            <!-- Item -->
            <div class="flex items-start gap-3 px-4 py-3.5">
                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M15 11v2" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">Checked in to <span class="font-medium">L-009</span></p>
                    <p class="text-xs text-gray-400">Sports Center</p>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap">3 days ago</span>
            </div>

        </div>

    </section>
@endsection