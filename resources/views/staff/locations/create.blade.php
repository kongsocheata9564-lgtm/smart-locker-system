@extends('layouts.app')

@section('title', 'Add Location | Smart Locker System')
@section('page_title', 'Add Location')

@section('content')
    @php
        // one place for the input style so every field matches
        $input = 'w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400';
    @endphp

    <section class="grid gap-4 bg-white rounded-xl p-4 max-w-2xl">

        <div>
            <h2 class="text-lg font-bold text-gray-800">Add Location</h2>
            <p class="text-sm text-gray-400">This shows up on the Select Location page right away.</p>
        </div>

        {{-- enctype is needed for the photo upload --}}
        <form method="POST" action="{{ route('staff.locations.store') }}" enctype="multipart/form-data" class="grid gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. ABC Mall" class="{{ $input }}">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="{{ $input }}">
                    <option value="">Choose category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="e.g. 123 Monivong Blvd, Phnom Penh" class="{{ $input }}">
                @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price per hour ($)</label>
                    <input type="number" step="0.01" name="price_per_hour" value="{{ old('price_per_hour') }}" placeholder="0.50" class="{{ $input }}">
                    @error('price_per_hour') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total lockers</label>
                    <input type="number" name="total_lockers" value="{{ old('total_lockers') }}" placeholder="24" class="{{ $input }}">
                    @error('total_lockers') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Photo (optional)</label>
                <input type="file" name="image" accept="image/*" class="{{ $input }}">
                <p class="text-xs text-gray-400 mt-1">Without a photo, the card uses a colored background.</p>
                @error('image') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('staff.locations.index') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">Save Location</button>
            </div>
        </form>

    </section>
@endsection