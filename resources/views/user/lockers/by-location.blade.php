@extends('layouts.user')

@section('title', $location->name . ' | Smart Locker System')
@section('page_title', $location->name)
@section('back', route('user.location.user'))

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-4">
    <div class="h-32 bg-gray-100">
        @if ($location->map)
            <img src="{{ $location->map }}" class="w-full h-full object-cover" alt="">
        @else
            <iframe src="https://maps.google.com/maps?q={{ urlencode($location->name . ', ' . $location->address) }}&z=15&output=embed"
                    class="w-full h-full border-0 pointer-events-none" loading="lazy"></iframe>
        @endif
    </div>
    <div class="p-4">
        <h2 class="font-extrabold text-[#123a6b]">{{ $location->name }}</h2>
        <p class="text-xs text-gray-500 mt-0.5">{{ $location->address }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <h3 class="text-sm font-bold text-[#123a6b] mb-2">Locker Availability</h3>

    <div class="flex items-center gap-3 text-[11px] font-semibold mb-3">
        <span class="text-green-600"><i class="bi bi-circle-fill text-[7px]"></i> Available {{ $counts['available'] }}</span>
        <span class="text-red-500"><i class="bi bi-circle-fill text-[7px]"></i> In Use {{ $counts['in_use'] }}</span>
        <span class="text-orange-500"><i class="bi bi-circle-fill text-[7px]"></i> Maintenance {{ $counts['maintenance'] }}</span>
    </div>

    <div id="lockerGrid" class="grid grid-cols-2 gap-3">
        @forelse ($lockers as $locker)
            @php
                $key = $locker->status === 'occupied' ? 'in_use' : $locker->status;
                $cfg = match ($key) {
                    'available'   => ['Available',   'bg-green-50',  'text-green-600',  'border-green-200',  'bi-unlock'],
                    'in_use'      => ['In Use',       'bg-red-50',    'text-red-500',    'border-red-200',    'bi-lock-fill'],
                    'maintenance' => ['Maintenance',  'bg-orange-50', 'text-orange-500', 'border-orange-200', 'bi-tools'],
                    default       => [ucfirst($key),  'bg-gray-50',   'text-gray-500',   'border-gray-200',   'bi-box'],
                };
            @endphp

            @if ($key === 'available')
                <a href="{{ route('user.lockers.confirm', $locker) }}"
                   class="locker-card block text-center bg-white border {{ $cfg[3] }} rounded-2xl p-3 no-underline active:scale-95 transition">
            @else
                <div class="locker-card block text-center bg-white border {{ $cfg[3] }} rounded-2xl p-3 opacity-70">
            @endif
                    <div class="w-10 h-10 mx-auto rounded-full {{ $cfg[1] }} flex items-center justify-center mb-1.5">
                        <i class="bi {{ $cfg[4] }} {{ $cfg[2] }}"></i>
                    </div>
                    <p class="text-sm font-extrabold text-gray-900">{{ $locker->locker_name }}</p>
                    <p class="text-[10px] font-semibold {{ $cfg[2] }}">{{ $cfg[0] }}</p>
                    <p class="text-[10px] text-gray-400">{{ ucfirst($locker->type) }}</p>
            @if ($key === 'available') </a> @else </div> @endif
        @empty
            <p class="col-span-2 text-center text-sm text-gray-400 py-8">No lockers at this location.</p>
        @endforelse
    </div>

    @if ($lockers->count() > 6)
        <button type="button" id="viewAll"
                class="w-full mt-3 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-[#123a6b]">
            View All Lockers ({{ $lockers->count() }})
        </button>
    @endif
</div>

<script>
    const cards = [...document.querySelectorAll('.locker-card')];
    const btn = document.getElementById('viewAll');
    cards.forEach((c, i) => { if (i >= 6) c.style.display = 'none'; });
    btn?.addEventListener('click', () => { cards.forEach(c => c.style.display = ''); btn.remove(); });
</script>

@endsection