@extends('layouts.guest')

@section('title', 'Login | Smart Locker System')
@section('page_title', 'Login')

@section('content')
    <div class="max-w-md mx-auto mt-10 mb-10 px-4">

        <!-- Tabs -->
        <div class="flex mb-8">
            <a href="{{ route('login') }}"
               class="flex-1 text-center pb-3 no-underline">
                <span class="block font-bold text-[#123a6b] pb-2 border-b-2 border-[#123a6b]">Login</span>
            </a>
            <a href="{{ route('register') }}"
               class="flex-1 text-center no-underline">
                <span class="block font-semibold text-gray-400 pb-3">Register</span>
            </a>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-[#123a6b] mb-2">Email or Username</label>
                <input type="text"
                       id="email"
                       name="email"
                       required
                       autofocus
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3.5 rounded-xl border-0 bg-[#eaf1fb] text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-[#1e5fc4] outline-none"
                       placeholder="someone@gmail.com">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-[#123a6b] mb-2">Password</label>
                <div class="relative">
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           class="w-full px-4 py-3.5 pr-11 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-[#1e5fc4] focus:border-transparent outline-none"
                           placeholder="••••••••••••">
                    <button type="button"
                            onclick="var i=document.getElementById('password'); var open=i.type==='password'; i.type = open ? 'text' : 'password'; document.getElementById('eyeOpen').classList.toggle('hidden', open); document.getElementById('eyeClosed').classList.toggle('hidden', !open);"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
                            aria-label="Show password">
                        <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eyeClosed" class="hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.3 20.3 0 0 1 5.06-5.94M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a20.3 20.3 0 0 1-3.42 4.61M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

           <div class="flex justify-end">
    <a href="{{ Route::has('password.request') ? route('password.request') : '#' }}" class="text-sm font-medium text-[#1e5fc4] no-underline hover:underline">
        Forget password?
    </a>
</div>

            <button type="submit"
                    class="w-full py-4 rounded-full text-white font-bold text-[15px] shadow-lg transition hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, #123a6b, #0d2a52);">
                Log In
            </button>
        </form>

        <div class="flex items-center gap-4 my-7">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-sm text-gray-400">or</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

       <div class="space-y-3">
    <a href="{{ Route::has('auth.google') ? route('auth.google') : '#' }}"
       class="w-full flex items-center justify-center gap-2.5 py-3.5 rounded-xl border border-gray-200 no-underline text-gray-800 font-medium hover:bg-gray-50 transition">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Continue with Google
    </a>

    <a href="{{ Route::has('auth.apple') ? route('auth.apple') : '#' }}"
       class="w-full flex items-center justify-center gap-2.5 py-3.5 rounded-xl border border-gray-200 no-underline text-gray-800 font-medium hover:bg-gray-50 transition">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M16.365 1.43c0 1.14-.462 2.096-1.106 2.842-.696.81-1.85 1.44-2.815 1.44-.132 0-.264-.021-.376-.032-.02-.117-.044-.303-.044-.489 0-1.108.53-2.174 1.13-2.868.69-.79 1.9-1.373 2.9-1.412.02.164.311.325.311.519zm2.85 16.17c-.396.918-.588 1.328-1.106 2.144-.72 1.126-1.734 2.527-2.988 2.539-1.113.012-1.402-.727-2.914-.716-1.512.011-1.83.728-2.943.716-1.254-.012-2.213-1.283-2.933-2.409-2.01-3.135-2.224-6.816-.981-8.775.882-1.392 2.276-2.207 3.588-2.207 1.335 0 2.175.732 3.281.732 1.073 0 1.724-.732 3.264-.732 1.166 0 2.4.635 3.281 1.732-2.883 1.581-2.415 5.698.451 6.976z"/>
        </svg>
        Continue with Apple
    </a>
</div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-[#1e5fc4] no-underline hover:underline">Register</a>
        </p>
    </div>
@endsection