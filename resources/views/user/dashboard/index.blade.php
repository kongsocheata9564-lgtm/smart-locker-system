@extends('layouts.user')

@section('title', 'Dashboard | Smart Locker System')
@section('page_title', 'Dashboard')

@section('content')
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
    @endphp
    <section class="grid gap-4">

        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $greeting }}, {{ auth()->user()->name }}</h2>
            <p class="text-sm text-gray-400">Find and manage your lockers easily.</p>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Total Bookings</p>
                </div>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalBookings }}</p>
                <p class="text-xs {{ $weekBookings ? 'text-green-500' : 'text-gray-400' }} mt-1">
                    {{ $weekBookings ? '+' . $weekBookings . ' this week' : 'None this week' }}
                </p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <path stroke-linecap="round" d="M15 11v2" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Active Lockers</p>
                </div>
                <p class="text-2xl font-semibold text-gray-800">{{ $activeLockers }}</p>
                <p class="text-xs text-gray-400 mt-1">Currently using</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-purple-50 text-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Available Lockers</p>
                </div>
                <p class="text-2xl font-semibold text-gray-800">{{ $available }}</p>
                <p class="text-xs text-gray-400 mt-1">Ready to use</p>
            </div>

        </div>

        <!-- Recent Activity -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-x-auto">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-50">
                <p class="text-sm font-semibold text-gray-700">Recent Activity</p>
                <a href="{{ route('user.usage-history.index') }}" class="text-xs text-blue-500 hover:underline">View all</a>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="font-medium px-4 py-2.5">Type</th>
                        <th class="font-medium px-4 py-2.5">Locker</th>
                        <th class="font-medium px-4 py-2.5">Location</th>
                        <th class="font-medium px-4 py-2.5">Time</th>
                        <th class="font-medium px-4 py-2.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($recent as $item)
                        @php
                            $released = !is_null($item->released_at);
                            $time = $released ? $item->released_at : $item->created_at;
                            $isActive = $item->status === 'active';
                        @endphp
                        <tr>
                            <td class="px-4 py-3 text-gray-600">{{ $released ? 'Released' : 'Booked' }}</td>
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $item->locker->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->locker->location->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $time->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full {{ $isActive ? 'bg-green-50 text-green-500' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $isActive ? 'Active' : 'Completed' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                No activity yet.
                                <a href="{{ route('location') }}" class="text-blue-500 hover:underline">Find a locker</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>
@endsection