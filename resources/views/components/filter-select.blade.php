@props([
    'name',
    'placeholder' => 'All',
])

<select name="{{ $name }}" onchange="this.form.submit()"
        {{ $attributes->merge(['class' => 'border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500']) }}>
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
</select>