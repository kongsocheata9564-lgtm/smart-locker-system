@extends('layouts.app1')

@section('title', 'Lockers | Smart Locker System')
@section('page_title', 'Lockers')

@section('content')
    <section class="grid gap-4 p-3 rounded-xl bg-white">

        <!-- Page header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Lockers</h2>
                <p class="text-sm text-gray-400">Manage all lockers across locations.</p>
            </div>

            <a href="#"
               class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Locker
            </a>
        </div>

        <!-- Search + filters bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white border border-gray-100 rounded-xl p-3 shadow-sm">

            <!-- Search input -->
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.15a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>
                <input type="text"
                       name="search"
                       placeholder="Search locker number..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
            </div>

            <!-- Locations filter -->
            <div class="relative w-full sm:w-44">
                <select name="location"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Locations</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Status filter -->
            <div class="relative w-full sm:w-40">
                <select name="status"
                        class="w-full appearance-none pl-3 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="in_use">In Use</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

        </div>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500 border-b border-gray-100">
                <th class="font-medium px-4 py-3 w-10">#</th>
                <th class="font-medium px-4 py-3">Locker #</th>
                <th class="font-medium px-4 py-3">Location</th>
                <th class="font-medium px-4 py-3">Status</th>
                <th class="font-medium px-4 py-3">Last Used</th>
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
                                <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                <rect x="13" y="13" width="7" height="7" rx="1.2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">L-001</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500">ABC Mall</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Available</span>
                </td>
                <td class="px-4 py-3 text-gray-400">-</td>
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
                                <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                <rect x="13" y="13" width="7" height="7" rx="1.2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">L-002</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500">ABC Mall</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">In Use</span>
                </td>
                <td class="px-4 py-3 text-gray-400">1 hr ago</td>
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
                                <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                <rect x="13" y="13" width="7" height="7" rx="1.2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">L-003</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500">National Library</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center bg-green-50 text-green-500 text-xs font-medium px-2.5 py-1 rounded-full">Available</span>
                </td>
                <td class="px-4 py-3 text-gray-400">-</td>
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
                                <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                <rect x="13" y="13" width="7" height="7" rx="1.2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">L-004</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500">National Library</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center bg-orange-50 text-orange-500 text-xs font-medium px-2.5 py-1 rounded-full">Maintenance</span>
                </td>
                <td class="px-4 py-3 text-gray-400">3 hrs ago</td>
                <td class="px-4 py-3 text-right">
                    <button type="button" class="text-gray-400 hover:text-gray-600 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                </td>
            </tr>

            <!-- Row 5 -->
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500">5</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="4" y="4" width="7" height="7" rx="1.2" />
                                <rect x="13" y="4" width="7" height="7" rx="1.2" />
                                <rect x="4" y="13" width="7" height="7" rx="1.2" />
                                <rect x="13" y="13" width="7" height="7" rx="1.2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">L-005</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500">Sports Center</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">In Use</span>
                </td>
                <td class="px-4 py-3 text-gray-400">45 min ago</td>
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