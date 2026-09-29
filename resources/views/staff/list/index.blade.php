@extends('layouts.app')

@section('title', 'User List | Smart Locker System')
@section('page_title', 'User Management')

@section('content')
    <section class="grid gap-4 bg-white rounded-xl p-4">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-800">User List</h2>
                <p class="text-sm text-gray-400">Manage all registered users in the system.</p>
            </div>
            <!-- Optional: Add User Button -->
            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Add User
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border border-gray-100 rounded-xl">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs text-gray-400 uppercase">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Registered</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $user->id }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'active')
                                    <span class="inline-flex items-center bg-green-50 text-green-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center bg-red-50 text-red-500 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-2">
            {{ $users->links() }}
        </div>

    </section>
@endsection