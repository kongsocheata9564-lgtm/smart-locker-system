@props([
    'name' => 'search',
    'placeholder' => 'Search...',
])

<div class="relative">
    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="7"/>
        <path stroke-linecap="round" d="m21 21-4.3-4.3"/>
    </svg>
    <input type="text" name="{{ $name }}" value="{{ request($name) }}" placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']) }}>
</div>