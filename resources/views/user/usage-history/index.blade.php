@extends('layouts.user')

@section('title', 'Usage History | Smart Locker System')
@section('page_title', 'Usage History')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <div>
            <h2 class="text-lg font-bold text-gray-800">Usage History</h2>
            <p class="text-sm text-gray-400">Track your locker usage and booking history.</p>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

            <!-- Locations filter -->
            <div class="relative w-full sm:w-44">
                <select name="location"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-white border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Locations</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Status filter -->
            <div class="relative w-full sm:w-40">
                <select name="status"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-white border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Date range (static text for now) -->
            <button type="button"
                    class="flex items-center gap-2 bg-white border border-gray-200 text-sm text-gray-600 px-4 py-2.5 rounded-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
                </svg>
                Sep 1, 2025 - Sep 28, 2026
            </button>

        </div>

        <!-- History table -->
        <div class="border border-gray-100 rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="font-medium px-4 py-3 w-10">#</th>
                        <th class="font-medium px-4 py-3">Locker</th>
                        <th class="font-medium px-4 py-3">Location</th>
                        <th class="font-medium px-4 py-3">Type</th>
                        <th class="font-medium px-4 py-3">Time</th>
                        <th class="font-medium px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">

                    <tr>
                        <td class="px-4 py-3 text-gray-400">1</td>
                        <td class="px-4 py-3 font-medium text-gray-700">A12</td>
                        <td class="px-4 py-3 text-gray-500">PSE Institute</td>
                        <td class="px-4 py-3 text-gray-500">Booked</td>
                        <td class="px-4 py-3 text-gray-500">Sep 28, 2026 09:00 AM</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-3 text-gray-400">2</td>
                        <td class="px-4 py-3 font-medium text-gray-700">B05</td>
                        <td class="px-4 py-3 text-gray-500">Library</td>
                        <td class="px-4 py-3 text-gray-500">Released</td>
                        <td class="px-4 py-3 text-gray-500">Sep 27, 2026 02:15 PM</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Completed</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-3 text-gray-400">3</td>
                        <td class="px-4 py-3 font-medium text-gray-700">C14</td>
                        <td class="px-4 py-3 text-gray-500">Shopping Mall</td>
                        <td class="px-4 py-3 text-gray-500">Released</td>
                        <td class="px-4 py-3 text-gray-500">Sep 26, 2026 10:30 AM</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Completed</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-3 text-gray-400">4</td>
                        <td class="px-4 py-3 font-medium text-gray-700">D08</td>
                        <td class="px-4 py-3 text-gray-500">Sports Center</td>
                        <td class="px-4 py-3 text-gray-500">Released</td>
                        <td class="px-4 py-3 text-gray-500">Sep 24, 2026 04:20 PM</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Completed</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-3 text-gray-400">5</td>
                        <td class="px-4 py-3 font-medium text-gray-700">A01</td>
                        <td class="px-4 py-3 text-gray-500">PSE Institute</td>
                        <td class="px-4 py-3 text-gray-500">Booked</td>
                        <td class="px-4 py-3 text-gray-500">Sep 22, 2026 11:00 AM</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Completed</span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </section>
@endsection