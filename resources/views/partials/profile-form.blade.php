@php
    $user = auth()->user();

    $initials = collect(explode(' ', trim($user->name)))
        ->filter()->take(2)
        ->map(fn ($w) => strtoupper(mb_substr($w, 0, 1)))
        ->implode('');

    $roleStyles = [
        'admin' => 'bg-purple-50 text-purple-600',
        'staff' => 'bg-blue-50 text-blue-600',
        'user'  => 'bg-green-50 text-green-600',
    ];
    $roleClass = $roleStyles[$user->role] ?? 'bg-gray-100 text-gray-600';

    $input = 'w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#1e5fc4] focus:border-transparent transition';
    $btn = 'inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full text-white text-sm font-semibold shadow-md transition hover:-translate-y-0.5';
    $btnBg = 'background: linear-gradient(135deg, #123a6b, #0d2a52);';
@endphp

<div class="grid gap-6 lg:grid-cols-3 max-w-5xl">

    {{-- Success message --}}
    @if (session('success'))
        <div class="lg:col-span-3 flex items-center gap-3 rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary card --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 text-center">
            <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-md"
                 style="background: linear-gradient(135deg, #1e5fc4, #123a6b);">
                {{ $initials }}
            </div>

            <p class="mt-4 text-lg font-semibold text-gray-800 truncate">{{ $user->name }}</p>
            <p class="text-sm text-gray-400 truncate">{{ $user->email }}</p>

            <span class="inline-flex mt-3 px-3 py-1 rounded-full text-xs font-semibold {{ $roleClass }}">
                {{ ucfirst($user->role) }}
            </span>

            <div class="mt-6 pt-5 border-t border-gray-100 grid gap-3 text-sm text-left">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Status</span>
                    <span class="inline-flex items-center gap-1.5 font-medium text-green-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        {{ ucfirst($user->status ?? 'active') }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Member since</span>
                    <span class="font-medium text-gray-700">{{ $user->created_at?->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Forms --}}
    <div class="lg:col-span-2 grid gap-6 content-start">

        {{-- Personal information --}}
        <form method="POST" action="{{ route('profile.update') }}"
              class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <h2 class="text-base font-semibold text-gray-800">Personal information</h2>
                <p class="text-sm text-gray-400">Update your name and email address.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-semibold text-[#123a6b] mb-2">Full name</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                        </svg>
                        <input id="name" name="name" type="text" required
                               value="{{ old('name', $user->name) }}" placeholder="John Doe"
                               class="{{ $input }}">
                    </div>
                    @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-[#123a6b] mb-2">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <input id="email" name="email" type="email" required
                               value="{{ old('email', $user->email) }}" placeholder="someone@gmail.com"
                               class="{{ $input }}">
                    </div>
                    @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-semibold text-[#123a6b] mb-2">Role</label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <input type="text" value="{{ ucfirst($user->role) }}" disabled
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed">
                </div>
                <p class="mt-1.5 text-xs text-gray-400">Your role is assigned by an administrator.</p>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="{{ $btn }}" style="{{ $btnBg }}">Save changes</button>
            </div>
        </form>

        {{-- Change password --}}
        <form method="POST" action="{{ route('profile.password') }}"
              class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <h2 class="text-base font-semibold text-gray-800">Change password</h2>
                <p class="text-sm text-gray-400">Use at least 8 characters.</p>
            </div>

            @php
                $eyeBtn = 'absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600';
                $lockIcon = 'absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400';
                $lockPath = 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z';
                $eyePath = 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z';
            @endphp

            <div class="grid gap-5">
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-[#123a6b] mb-2">Current password</label>
                    <div class="relative">
                        <svg class="{{ $lockIcon }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $lockPath }}" /></svg>
                        <input id="current_password" name="current_password" type="password" required placeholder="••••••••••••"
                               class="{{ $input }} pr-11">
                        <button type="button" class="{{ $eyeBtn }}" onclick="togglePw('current_password')" aria-label="Show password">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $eyePath }}" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </button>
                    </div>
                    @if ($errors->password->has('current_password'))
                        <p class="mt-1.5 text-sm text-red-600">{{ $errors->password->first('current_password') }}</p>
                    @endif
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="new_password" class="block text-sm font-semibold text-[#123a6b] mb-2">New password</label>
                        <div class="relative">
                            <svg class="{{ $lockIcon }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $lockPath }}" /></svg>
                            <input id="new_password" name="password" type="password" required placeholder="••••••••••••"
                                   class="{{ $input }} pr-11">
                            <button type="button" class="{{ $eyeBtn }}" onclick="togglePw('new_password')" aria-label="Show password">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $eyePath }}" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        @if ($errors->password->has('password'))
                            <p class="mt-1.5 text-sm text-red-600">{{ $errors->password->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-[#123a6b] mb-2">Confirm new password</label>
                        <div class="relative">
                            <svg class="{{ $lockIcon }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $lockPath }}" /></svg>
                            <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="••••••••••••"
                                   class="{{ $input }} pr-11">
                            <button type="button" class="{{ $eyeBtn }}" onclick="togglePw('password_confirmation')" aria-label="Show password">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $eyePath }}" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="{{ $btn }}" style="{{ $btnBg }}">Update password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePw(id) {
        var i = document.getElementById(id);
        i.type = i.type === 'password' ? 'text' : 'password';
    }
</script>
