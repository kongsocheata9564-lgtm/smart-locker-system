@extends('layouts.app')

@section('title', 'Manage Roles | Smart Locker System')
@section('page_title', 'Manage Roles')

@section('content')
    <section class="grid gap-4">

        @if (session('success'))
            <div class="rounded-lg bg-green-50 text-green-600 text-sm px-4 py-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-50 text-red-600 text-sm px-4 py-3">{{ session('error') }}</div>
        @endif

        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or email"
                   class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-sm outline-none focus:ring-2 focus:ring-[#1e5fc4]">
            <button class="px-4 py-2.5 rounded-lg bg-[#123a6b] text-white text-sm font-medium">Search</button>
        </form>

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="font-medium px-4 py-2.5">Name</th>
                        <th class="font-medium px-4 py-2.5">Email</th>
                        <th class="font-medium px-4 py-2.5">Role</th>
                        <th class="font-medium px-4 py-2.5">Change</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($users as $u)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $u->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $u->email }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex bg-blue-50 text-blue-500 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($u->id === auth()->id())
                                    <span class="text-xs text-gray-400">This is you</span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.role', $u) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="rounded-lg border border-gray-200 px-2 py-1.5 text-sm">
                                            @foreach (['user', 'staff', 'admin'] as $r)
                                                <option value="{{ $r }}" @selected($u->role === $r)>{{ ucfirst($r) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="px-3 py-1.5 rounded-lg bg-[#123a6b] text-white text-xs font-medium">Save</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </section>
@endsection
