@extends('layouts.app')

@section('title', 'Locations | Smart Locker System')
@section('page_title', 'Locations')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Locations</h2>
                <p class="text-sm text-gray-400">Manage all locker locations.</p>
            </div>
            <a href="{{ route('staff.locations.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                + Add Location
            </a>
        </div>

        {{-- shows after saving a new location --}}
        @if (session('success'))
            <div class="bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="border border-gray-100 rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="font-medium px-4 py-3">Name</th>
                        <th class="font-medium px-4 py-3">Category</th>
                        <th class="font-medium px-4 py-3">Address</th>
                        <th class="font-medium px-4 py-3">Price</th>
                        <th class="font-medium px-4 py-3">Lockers</th>
                        <th class="font-medium px-4 py-3 text-right">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($locations as $location)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $location->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $location->category }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $location->address }}</td>
                            <td class="px-4 py-3 text-gray-500">${{ number_format($location->price_per_hour, 2) }}/hr</td>
                            <td class="px-4 py-3 text-gray-500">{{ $location->free_lockers }} / {{ $location->total_lockers }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('location.show', $location) }}" class="text-blue-500 hover:underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">No locations yet. Click "Add Location" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $locations->links() }}

    </section>
@endsection