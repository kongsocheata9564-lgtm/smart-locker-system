@props([
    'label',
    'value',
    'color' => 'blue',
])

@php
    // Full class names are written out so Tailwind can detect them.
    $styles = match ($color) {
        'orange' => 'bg-orange-50 text-orange-600 ring-orange-100',
        'green'  => 'bg-green-50 text-green-600 ring-green-100',
        'red'    => 'bg-red-50 text-red-600 ring-red-100',
        default  => 'bg-blue-50 text-blue-600 ring-blue-100',
    };
@endphp

<div class="grid grid-cols-[auto_1fr] items-center gap-x-4 gap-y-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
    {{-- Label: top row, aligned with the number --}}
    <p class="col-start-2 row-start-1 text-xs text-gray-500">{{ $label }}</p>

    {{-- Icon: bottom row, left --}}
    <span class="col-start-1 row-start-2 w-12 h-12 rounded-lg {{ $styles }} flex items-center justify-center ring-1 ring-inset">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            {{ $icon }}
        </svg>
    </span>

    {{-- Number: bottom row, right --}}
    <p class="col-start-2 row-start-2 text-2xl font-bold text-gray-900">{{ $value }}</p>
</div>