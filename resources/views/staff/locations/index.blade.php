@extends('layouts.app1')

@section('title', 'Locations | Smart Locker System')
@section('page_title', 'Locations')

@section('content')
    <section class="grid gap-4 p-3 rounded-xl bg-white">

        <!-- Page header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Locations</h2>
                <p class="text-sm text-gray-400">Manage all locker locations and their information.</p>
            </div>

            <a href="#"
               class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Location
            </a>
        </div>

        <!-- Search + filter bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white border border-gray-100 rounded-xl p-3 shadow-sm">

            <!-- Search input -->
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.15a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>
                <input type="text"
                       name="search"
                       placeholder="Search locations..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
            </div>

            <!-- Status filter -->
            <div class="relative w-full sm:w-40">
                <select name="status"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

        </div>

                

        <!-- Locations table -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="font-medium px-4 py-3 w-10">#</th>
                        <th class="font-medium px-4 py-3">Name</th>
                        <th class="font-medium px-4 py-3">Address</th>
                        <th class="font-medium px-4 py-3">Type</th>
                        <th class="font-medium px-4 py-3">Status</th>
                        <th class="font-medium px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">

                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">1</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">ABC Mall</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">123 Monivong Blvd, Phnom Penh</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">Shopping</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-gray-400 hover:text-gray-600 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">2</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5A2.5 2.5 0 006.5 22H20V4H6.5A2.5 2.5 0 004 6.5v13z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">National Library</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">St. 93, Phnom Penh</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">Library</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-gray-400 hover:text-gray-600 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">3</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5M6 10.5v9.75h12V10.5" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Sports Center</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">St. 217, Phnom Penh</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">Sports</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-gray-400 hover:text-gray-600 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">4</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l9 4.5-9 4.5-9-4.5L12 3zM3 12l9 4.5 9-4.5M3 16.5l9 4.5 9-4.5" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">University Building</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">Russian Blvd, Phnom Penh</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">Education</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-gray-400 hover:text-gray-600 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </section>
@endsection