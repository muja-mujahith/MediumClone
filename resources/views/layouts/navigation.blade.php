<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden sm:flex items-center gap-1 ml-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ config('app.name') }}
                    </x-nav-link>
                    @auth
                    <x-nav-link :href="route('post.following')" :active="request()->routeIs('post.following')">
                        {{ __('Following') }}
                    </x-nav-link>
                    <x-nav-link :href="route('post.mypost')" :active="request()->routeIs('post.mypost')">
                        {{ __('My Posts') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2">

                {{-- Create Post Button (always shown) --}}
                <a href="{{ route('post.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-500 hover:bg-indigo-600 active:scale-95 text-white text-sm font-semibold transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                        <path stroke-linecap="round" d="M8 3v10M3 8h10" />
                    </svg>
                    Create Post
                </a>

                @auth
                {{-- User Dropdown --}}
                <div class="hidden sm:flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-150">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                {{ Auth::user()->name }}
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth

                @guest
                {{-- Auth Buttons --}}
                <div class="hidden sm:flex items-center gap-2 pl-2 border-l border-gray-100">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                            <circle cx="8" cy="5.5" r="2.5" />
                            <path stroke-linecap="round" d="M3 13c0-2.76 2.24-5 5-5s5 2.24 5 5" />
                        </svg>
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold transition-all duration-150 hover:-translate-y-px hover:shadow-md hover:shadow-indigo-200 active:translate-y-0 active:shadow-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 16 16">
                            <path stroke-linecap="round" d="M11 8h4M13 6v4M8 10c-2.76 0-5 2.24-5 5M8 10a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                        Sign up
                    </a>
                </div>
                @endguest

                {{-- Hamburger --}}
                <button @click="open = !open"
                    class="sm:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-150 focus:outline-none">
                    <span :class="{ 'rotate-45 translate-y-2': open }" class="block w-5 h-0.5 bg-gray-500 transition-all duration-250 origin-center"></span>
                    <span :class="{ 'opacity-0 scale-x-0': open }" class="block w-5 h-0.5 bg-gray-500 transition-all duration-250"></span>
                    <span :class="{ '-rotate-45 -translate-y-2': open }" class="block w-5 h-0.5 bg-gray-500 transition-all duration-250 origin-center"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="sm:hidden absolute w-full bg-white border-b border-gray-100 shadow-lg px-4 pb-4 pt-2">

        <div class="flex flex-col gap-1 mb-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">🏠 Home</x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('post.following')">👥 Following</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('post.mypost')">📝 My Posts</x-responsive-nav-link>
            @endauth
            <a href="{{ route('post.create') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">✏️ Create Post</a>
        </div>

        @guest
        <div class="flex flex-col gap-2 pt-3 border-t border-gray-100">
            <a href="{{ route('login') }}"
                class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                    <circle cx="8" cy="5.5" r="2.5" />
                    <path stroke-linecap="round" d="M3 13c0-2.76 2.24-5 5-5s5 2.24 5 5" />
                </svg>
                Log in to your account
            </a>
            <a href="{{ route('register') }}"
                class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 16 16">
                    <path stroke-linecap="round" d="M11 8h4M13 6v4M8 10c-2.76 0-5 2.24-5 5M8 10a3 3 0 100-6 3 3 0 000 6z" />
                </svg>
                Create a free account
            </a>
        </div>
        @endguest

        @auth
        <div class="pt-3 border-t border-gray-100">
            <div class="px-1 mb-2">
                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
            </form>
        </div>
        @endauth
    </div>
</nav>