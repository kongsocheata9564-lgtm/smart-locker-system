@extends('layouts.app1')

@section('title', 'Locker Usage | Smart Locker System')
@section('page_title', 'Locker Usage')

@section('content')
    <section class="grid gap-4 p-3 rounded-xl bg-white">

        <!-- Page header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Locker Usage</h2>
                <p class="text-sm text-gray-400">Track locker usage and activity logs.</p>
            </div>

            <!-- Date range picker -->
            <button type="button"
                    class="flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-sm text-gray-600 px-4 py-2.5 rounded-lg shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
                </svg>
                <span>16 Sep 2025 - 16 Sep 2025</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25v13.5m6-13.5v13.5M4.5 8.25h15M4.5 15.75h15" />
                </svg>
            </button>
        </div>

        <!-- Stats row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <!-- Total Check-ins -->
    <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
        <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Check-ins</p>
            <p class="text-xl font-semibold text-gray-800">87</p>
            <p class="text-xs text-green-500">+12% vs last week</p>
        </div>
    </div>

    <!-- Total Releases -->
    <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
        <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21M6.375 6.375l1.06 1.06m9.129 9.129l1.06 1.06m0-11.25l-1.06 1.06m-9.129 9.129l-1.06 1.06M12 9a3 3 0 100 6 3 3 0 000-6z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Releases</p>
            <p class="text-xl font-semibold text-gray-800">83</p>
            <p class="text-xs text-green-500">+10% vs last week</p>
        </div>
    </div>

    <!-- Active Users -->
    <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
        <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Active Users</p>
            <p class="text-xl font-semibold text-gray-800">48</p>
            <p class="text-xs text-green-500">+8% vs last week</p>
        </div>
    </div>

    <!-- Avg. Duration -->
    <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
        <div class="w-11 h-11 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-400">Avg. Duration</p>
            <p class="text-xl font-semibold text-gray-800">2h 36m</p>
            <p class="text-xs text-red-500">-5% vs last week</p>
        </div>
    </div>

</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    <!-- Usage Trend (chart) -->
   <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-gray-700">Usage Trend</h3>
        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Check-ins
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-teal-400"></span> Releases
            </span>
        </div>
    </div>

    <!-- Static line chart (SVG) -->
    <div class="flex gap-2">

        <!-- Y-axis labels -->
        <div class="flex flex-col justify-between text-xs text-gray-400 py-1" style="height: 190px;">
            <span>40</span>
            <span>20</span>
            <span>0</span>
        </div>

        <div class="flex-1">
            <svg viewBox="0 0 600 190" class="w-full h-48" preserveAspectRatio="none">
                <!-- horizontal gridlines: 0, 20, 40 -->
                <line x1="0" y1="10"  x2="600" y2="10"  stroke="#f1f5f9" stroke-width="1" />
                <line x1="0" y1="90"  x2="600" y2="90"  stroke="#f1f5f9" stroke-width="1" />
                <line x1="0" y1="170" x2="600" y2="170" stroke="#e2e8f0" stroke-width="1" />

                <!--
                    Scale: y = 170 - (value / 40 * 160)
                    Points (10 Sep -> 16 Sep), x spaced evenly 0..600 in 6 steps of 100
                    Check-ins: 20, 18, 22, 20, 25, 40, 33
                    Releases:  12, 10, 15, 13, 18, 28, 24
                -->

                <!-- Check-ins area + line -->
                <polygon points="0,90 100,98 200,82 300,90 400,70 500,10 600,38 600,170 0,170"
                         fill="#3b82f6" fill-opacity="0.08" />
                <polyline points="0,90 100,98 200,82 300,90 400,70 500,10 600,38"
                          fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                <circle cx="0"   cy="90" r="4" fill="#3b82f6" />
                <circle cx="100" cy="98" r="4" fill="#3b82f6" />
                <circle cx="200" cy="82" r="4" fill="#3b82f6" />
                <circle cx="300" cy="90" r="4" fill="#3b82f6" />
                <circle cx="400" cy="70" r="4" fill="#3b82f6" />
                <circle cx="500" cy="10" r="4" fill="#3b82f6" />
                <circle cx="600" cy="38" r="4" fill="#3b82f6" />

                <!-- Releases area + line -->
                <polygon points="0,122 100,130 200,110 300,118 400,98 500,58 600,74 600,170 0,170"
                         fill="#2dd4bf" fill-opacity="0.08" />
                <polyline points="0,122 100,130 200,110 300,118 400,98 500,58 600,74"
                          fill="none" stroke="#2dd4bf" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                <circle cx="0"   cy="122" r="4" fill="#2dd4bf" />
                <circle cx="100" cy="130" r="4" fill="#2dd4bf" />
                <circle cx="200" cy="110" r="4" fill="#2dd4bf" />
                <circle cx="300" cy="118" r="4" fill="#2dd4bf" />
                <circle cx="400" cy="98"  r="4" fill="#2dd4bf" />
                <circle cx="500" cy="58"  r="4" fill="#2dd4bf" />
                <circle cx="600" cy="74"  r="4" fill="#2dd4bf" />
            </svg>

            <!-- X-axis labels -->
            <div class="flex justify-between text-xs text-gray-400 mt-2">
                <span>10 Sep</span>
                <span>11 Sep</span>
                <span>12 Sep</span>
                <span>13 Sep</span>
                <span>14 Sep</span>
                <span>15 Sep</span>
                <span>16 Sep</span>
            </div>
        </div>
    </div>
</div>

    <!-- Top Locations -->
    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Top Locations</h3>

        <div class="flex justify-between text-xs text-gray-400 mb-2">
            <span>Location</span>
            <span>Usage</span>
        </div>

        <div class="flex flex-col gap-4">

            <!-- Row -->
            <div>
                <div class="flex justify-between text-sm text-gray-700 mb-1">
                    <span>ABC Mall</span>
                    <span class="font-medium">34</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: 85%"></div>
                </div>
            </div>

            <!-- Row -->
            <div>
                <div class="flex justify-between text-sm text-gray-700 mb-1">
                    <span>National Library</span>
                    <span class="font-medium">22</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: 55%"></div>
                </div>
            </div>

            <!-- Row -->
            <div>
                <div class="flex justify-between text-sm text-gray-700 mb-1">
                    <span>Sports Center</span>
                    <span class="font-medium">18</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: 45%"></div>
                </div>
            </div>

            <!-- Row -->
            <div>
                <div class="flex justify-between text-sm text-gray-700 mb-1">
                    <span>University Building</span>
                    <span class="font-medium">13</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: 32%"></div>
                </div>
            </div>

        </div>
    </div>

</div>
    </section>
@endsection