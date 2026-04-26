<x-guest-layout>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-5 text-sm text-center" :status="session('status')" />

    {{-- Brand / Logo --}}
    <div class="flex flex-col items-center gap-2 mb-8">
        <div class="w-11 h-11 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-md">
            <x-application-logo class="w-6 h-6 fill-white" />
        </div>
        <h1 class="text-xl font-semibold text-gray-900">Welcome back</h1>
        <p class="text-sm text-gray-500">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="mb-1.5 text-sm font-medium" />
            <x-text-input
                id="email"
                class="block w-full text-sm rounded-xl py-2.5 px-3"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="you@example.com"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-1.5 text-sm font-medium" />
            <x-text-input
                id="password"
                class="block w-full text-sm rounded-xl py-2.5 px-3"
                type="password"
                name="password"
                placeholder="••••••••"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="w-4 h-4 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember_me" class="text-sm text-gray-600 select-none">
                {{ __('Remember me') }}
            </label>
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center py-2.5 text-sm rounded-xl mt-1">
            {{ __('Sign in') }}
        </x-primary-button>

        {{-- Forgot password --}}
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="text-center text-sm text-indigo-600 hover:text-indigo-700 transition-colors">
                {{ __('Forgot your password?') }}
            </a>
        @endif

        {{-- Divider --}}
        @if (Route::has('register'))
            <div class="flex items-center gap-3 my-1">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">or</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Sign up link --}}
            <p class="text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">
                    Sign up
                </a>
            </p>
        @endif

    </form>

</x-guest-layout>