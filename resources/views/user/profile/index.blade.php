@extends('layouts.user')

@section('title', 'Profile | Smart Locker System')
@section('page_title', 'Profile')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <div>
            <h2 class="text-lg font-bold text-gray-800">Profile</h2>
            <p class="text-sm text-gray-400">Manage your account information.</p>
        </div>

        <!-- Profile header card -->
        <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-4">
            <!-- Avatar (swap for <img> once you have a photo) -->
            <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xl font-bold shrink-0 overflow-hidden">
                {{-- <img src="/path/to/avatar.jpg" alt="{{ $user->name }}" class="w-full h-full object-cover"> --}}
                
                {{-- Dynamic Initials (e.g., "Somnang Dara" becomes "SD") --}}
                {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strstr($user->name, ' '), 1, 1)) }}
            </div>
            <div>
                {{-- Dynamic Name and Email --}}
                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                
                {{-- Dynamic Role (capitalized) --}}
                <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-0.5 rounded-full mt-1">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Account information -->
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700">Account Information</h3>
                {{-- TODO: point at your edit profile route --}}
                {{-- <a href="{{ route('user.profile.edit') }}" class="..."> --}}
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Edit Profile
                </a>
            </div>

            <div class="grid gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Full Name</p>
                    <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Email</p>
                    <p class="text-sm font-medium text-gray-800">{{ $user->email }}</p>
                </div>
                
                {{-- NOTE: If you want Phone and Student ID, you must add them to your users table migration! --}}
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Phone Number</p>
                    <p class="text-sm font-medium text-gray-800">+855 12 245 678</p> 
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Student ID</p>
                    <p class="text-sm font-medium text-gray-800">PSE-00123</p>
                </div>
            </div>
        </div>

    </section>
@endsection