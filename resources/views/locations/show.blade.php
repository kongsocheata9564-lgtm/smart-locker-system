@extends('layouts.guest')

@section('title', $location->name . ' | Smart Locker System')
@section('page_title', 'Location Detail')

@section('content')
@php
    $wrap = 'w-full max-w-[1600px] mx-auto px-5 sm:px-8 lg:px-12';
    $lockers = $location->lockers;
    $total = $lockers->count();
    $availableCount = $lockers->where('status', 'available')->count();
    $occupiedCount = $lockers->whereIn('status', ['occupied', 'in_use'])->count();
    $maintenanceCount = $lockers->where('status', 'maintenance')->count();
    $firstFree = $lockers->firstWhere('status', 'available');
    $statusStyle = [
        'available' => ['label' => 'Available', 'text' => 'text-green-600', 'bg' => 'bg-green-50', 'border' => 'border-green-100', 'dot' => 'bg-green-500'],
        'occupied' => ['label' => 'In Use', 'text' => 'text-red-500', 'bg' => 'bg-red-50', 'border' => 'border-red-100', 'dot' => 'bg-red-500'],
        'in_use' => ['label' => 'In Use', 'text' => 'text-red-500', 'bg' => 'bg-red-50', 'border' => 'border-red-100', 'dot' => 'bg-red-500'],
        'maintenance' => ['label' => 'Maintenance', 'text' => 'text-orange-500', 'bg' => 'bg-orange-50', 'border' => 'border-orange-100', 'dot' => 'bg-orange-500'],
    ];
    $sizeOptions = ['small' => 'Small', 'medium' => 'Medium', 'large' => 'Large'];
    $percentage = static fn (int $count): int => $total > 0 ? (int) round($count / $total * 100) : 0;
@endphp

    <div class="w-full bg-gray-50 text-left min-h-screen">
        <section class="relative w-full overflow-hidden bg-[#0d2a52] text-white pt-8 pb-24 sm:pt-10 sm:pb-28">
            <div class="{{ $wrap }} relative z-10">
                <a href="{{ route('location') }}" class="inline-flex items-center gap-2 text-[13px] font-semibold text-white/80 hover:text-white no-underline mb-5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                    </svg>
                    All locations
                </a>

                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="bg-white text-[#0d2a52] text-[11.5px] font-bold px-3 py-1 rounded-full">{{ $location->category }}</span>
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-[11.5px] font-semibold px-3 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span> Open 24/7
                    </span>
                </div>

                <h1 class="text-[32px] sm:text-[48px] font-extrabold leading-tight">{{ $location->name }}</h1>

                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-3 text-[14px] text-white/85">
                    <p class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $location->address }}
                    </p>
                    @if ($location->rating !== null)
                        <p class="flex items-center gap-1.5">
                            <span class="text-amber-300">&#9733;</span>
                            <span class="font-bold text-white">{{ number_format((float) $location->rating, 1) }}</span>
                        </p>
                    @endif
                </div>
            </div>
        </section>

        <section class="{{ $wrap }} -mt-12 relative z-20 pb-32">
            <div class="grid lg:grid-cols-3 gap-6 items-start">
                <aside class="order-1 lg:order-2 lg:sticky lg:top-6 grid gap-4">
                    <div class="bg-white rounded-3xl shadow-xl p-6">
                        <p class="text-[13px] font-semibold text-gray-500">Locker availability</p>
                        <p class="mt-1">
                            <span class="text-[40px] font-extrabold text-[#0d2a52] leading-none">{{ $availableCount }}</span>
                            <span class="text-[14px] text-gray-500 font-medium"> of {{ $total }} free</span>
                        </p>

                        <div class="flex h-2.5 rounded-full overflow-hidden bg-gray-100 mt-4">
                            <span class="bg-green-500" style="width: {{ $percentage($availableCount) }}%"></span>
                            <span class="bg-red-500" style="width: {{ $percentage($occupiedCount) }}%"></span>
                            <span class="bg-orange-500" style="width: {{ $percentage($maintenanceCount) }}%"></span>
                        </div>

                        <div class="grid gap-2.5 mt-4 text-[13.5px]">
                            @foreach ([['available', $availableCount], ['occupied', $occupiedCount], ['maintenance', $maintenanceCount]] as $row)
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $statusStyle[$row[0]]['dot'] }}"></span>
                                        {{ $statusStyle[$row[0]]['label'] }}
                                    </span>
                                    <span class="font-bold text-gray-900">{{ $row[1] }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if ($firstFree)
                            <a href="{{ route('locker.show', $firstFree) }}" class="mt-6 w-full flex items-center justify-center gap-2 bg-[#0d2a52] hover:bg-[#1e5fc4] text-white font-bold text-[14.5px] rounded-full px-6 py-3.5 no-underline transition">
                                Book first available
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                            <p class="text-center text-[12px] text-gray-400 mt-2">Locker {{ $firstFree->name }} &middot; or pick your own</p>
                        @else
                            <p class="mt-6 text-center text-sm text-gray-400">No lockers are available right now.</p>
                        @endif
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                        <p class="text-[15px] font-bold text-gray-900 mb-4">Pricing</p>
                        <div class="grid gap-3">
                            @foreach ($sizeOptions as $size => $label)
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-xl bg-[#eaf1fb] text-[#17488a] font-extrabold text-[13px] flex items-center justify-center">{{ strtoupper(substr($size, 0, 1)) }}</span>
                                    <p class="flex-1 text-[13.5px] font-bold text-gray-900">{{ $label }}</p>
                                    <p class="text-[15px] font-extrabold text-[#0d2a52]">${{ number_format((float) $location->price_per_hour, 2) }}<span class="text-[11px] font-medium text-gray-500">/hr</span></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <div class="order-2 lg:order-1 lg:col-span-2 bg-white rounded-3xl shadow-xl p-5 sm:p-7">
                    <div class="flex items-end justify-between gap-4 mb-5">
                        <div>
                            <p class="text-[12px] font-bold uppercase tracking-wider text-[#1e5fc4]">Choose a locker</p>
                            <h2 class="text-[22px] sm:text-[26px] font-extrabold text-gray-900 leading-tight">Available at this location</h2>
                        </div>
                        <p class="text-[13px] text-gray-500 whitespace-nowrap"><span id="lockCount" class="font-bold text-gray-900">{{ $total }}</span> lockers</p>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto pb-1">
                        @foreach ([['all', 'All', $total], ['available', 'Available', $availableCount], ['occupied', 'In Use', $occupiedCount], ['maintenance', 'Maintenance', $maintenanceCount]] as $tab)
                            <button type="button" data-status-filter="{{ $tab[0] }}" class="status-pill shrink-0 text-[13px] font-semibold px-4 py-2 rounded-full transition {{ $tab[0] === 'all' ? 'bg-[#1e5fc4] text-white' : 'bg-[#eaf1fb] text-[#1e5fc4] hover:bg-[#dbe8fb]' }}">
                                {{ $tab[1] }} <span class="opacity-70">({{ $tab[2] }})</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto mt-3 pb-1">
                        <span class="text-[12.5px] text-gray-500 font-medium mr-1">Size</span>
                        @foreach ([['all', 'Any'], ['small', 'Small'], ['medium', 'Medium'], ['large', 'Large']] as $chip)
                            <button type="button" data-size-filter="{{ $chip[0] }}" class="size-pill shrink-0 text-[12.5px] font-semibold px-3.5 py-1.5 rounded-full border transition {{ $chip[0] === 'all' ? 'bg-[#0d2a52] text-white border-[#0d2a52]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300' }}">
                                {{ $chip[1] }}
                            </button>
                        @endforeach
                    </div>

                    <div id="lockGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 mt-6">
                        @forelse ($lockers as $locker)
                            @php
                                $status = $locker->status === 'in_use' ? 'occupied' : $locker->status;
                                $style = $statusStyle[$status] ?? ['label' => ucfirst($status), 'text' => 'text-gray-500', 'bg' => 'bg-gray-50', 'border' => 'border-gray-100', 'dot' => 'bg-gray-400'];
                                $size = strtolower($locker->type);
                            @endphp
                            <a href="{{ route('locker.show', $locker) }}" data-locker data-status="{{ $status }}" data-size="{{ $size }}" class="group relative flex flex-col items-center gap-2 bg-white border {{ $style['border'] }} rounded-2xl p-4 no-underline shadow-sm transition hover:shadow-lg hover:-translate-y-1 {{ $status === 'available' ? '' : 'opacity-80' }}">
                                <span class="absolute top-2.5 right-2.5 text-[10.5px] font-bold text-gray-500 bg-gray-100 rounded-md px-1.5 py-0.5">{{ strtoupper(substr($size, 0, 1)) }}</span>
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl {{ $style['bg'] }} {{ $style['text'] }}">
                                    @if ($status === 'maintenance')
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L1.5 3l1.5-1.5L7.5 4.5v1.409l4.26 4.26" /></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2" /><path stroke-linecap="round" d="M15 11v2" /></svg>
                                    @endif
                                </div>
                                <p class="text-[14.5px] font-bold text-gray-800">{{ $locker->name }}</p>
                                <span class="flex items-center gap-1.5 text-[12px] font-semibold {{ $style['text'] }}"><span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>{{ $style['label'] }}</span>
                                @if ($status === 'available')
                                    <p class="text-[12px] text-gray-500">${{ number_format((float) $location->price_per_hour, 2) }}<span class="text-gray-400">/hr</span></p>
                                @endif
                            </a>
                        @empty
                            <p class="col-span-full text-center py-14 text-sm text-gray-400">No lockers have been added to this location yet.</p>
                        @endforelse
                    </div>

                    <div id="lockEmpty" class="hidden text-center py-14">
                        <p class="text-[16px] font-bold text-gray-900">No lockers match</p>
                        <p class="text-[13px] text-gray-500 mt-1">Try another status or size.</p>
                        <button id="lockReset" type="button" class="mt-4 bg-[#1e5fc4] hover:bg-[#17488a] text-white text-[13px] font-bold rounded-full px-6 py-2.5 transition">Reset filters</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lockers = document.querySelectorAll('[data-locker]');
            var statusButtons = document.querySelectorAll('.status-pill');
            var sizeButtons = document.querySelectorAll('.size-pill');
            var count = document.getElementById('lockCount');
            var empty = document.getElementById('lockEmpty');
            var reset = document.getElementById('lockReset');
            var activeStatus = 'all';
            var activeSize = 'all';

            function paint(buttons, attribute, active, activeClasses, inactiveClasses) {
                buttons.forEach(function (button) {
                    var selected = button.getAttribute(attribute) === active;
                    activeClasses.forEach(function (className) { button.classList.toggle(className, selected); });
                    inactiveClasses.forEach(function (className) { button.classList.toggle(className, !selected); });
                });
            }

            function render() {
                var shown = 0;
                lockers.forEach(function (locker) {
                    var matches = (activeStatus === 'all' || locker.dataset.status === activeStatus)
                        && (activeSize === 'all' || locker.dataset.size === activeSize);
                    locker.classList.toggle('hidden', !matches);
                    if (matches) { shown++; }
                });
                count.textContent = shown;
                empty.classList.toggle('hidden', shown !== 0);
            }

            statusButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    activeStatus = button.dataset.statusFilter;
                    paint(statusButtons, 'data-status-filter', activeStatus, ['bg-[#1e5fc4]', 'text-white'], ['bg-[#eaf1fb]', 'text-[#1e5fc4]', 'hover:bg-[#dbe8fb]']);
                    render();
                });
            });

            sizeButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    activeSize = button.dataset.sizeFilter;
                    paint(sizeButtons, 'data-size-filter', activeSize, ['bg-[#0d2a52]', 'text-white', 'border-[#0d2a52]'], ['bg-white', 'text-gray-600', 'border-gray-200', 'hover:border-gray-300']);
                    render();
                });
            });

            reset.addEventListener('click', function () {
                activeStatus = 'all';
                activeSize = 'all';
                paint(statusButtons, 'data-status-filter', activeStatus, ['bg-[#1e5fc4]', 'text-white'], ['bg-[#eaf1fb]', 'text-[#1e5fc4]', 'hover:bg-[#dbe8fb]']);
                paint(sizeButtons, 'data-size-filter', activeSize, ['bg-[#0d2a52]', 'text-white', 'border-[#0d2a52]'], ['bg-white', 'text-gray-600', 'border-gray-200', 'hover:border-gray-300']);
                render();
            });
        });
    </script>
@endsection
