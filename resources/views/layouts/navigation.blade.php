<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">

            {{-- Logo + Nav Links --}}
            <div class="flex items-center gap-2 min-w-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 shrink-0">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                </a>

                {{-- Desktop nav links only --}}
                <div class="hidden sm:flex items-center gap-1 ml-1">
                    <div class="w-px h-5 bg-gray-200 mx-1"></div>

                    <a href="{{ route('dashboard') }}"
                        class="group relative flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[13px] font-medium transition-all duration-150
                        {{ request()->routeIs('dashboard')
                            ? 'text-gray-900 bg-gray-100'
                            : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22" />
                        </svg>
                        {{ config('app.name') }}
                    </a>

                    @auth
                    <a href="{{ route('post.following') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[13px] font-medium transition-all duration-150
                        {{ request()->routeIs('post.following')
                            ? 'text-gray-900 bg-gray-100'
                            : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                        Following
                    </a>

                    <a href="{{ route('post.mypost') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[13px] font-medium transition-all duration-150
                        {{ request()->routeIs('post.mypost')
                            ? 'text-gray-900 bg-gray-100'
                            : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        My Posts
                    </a>
                    @endauth
                </div>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2">

                {{-- Desktop-only buttons --}}
                <a href="{{ route('category.create') }}"
                    class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Category
                </a>

                <a href="{{ route('post.create') }}"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-500 hover:bg-indigo-600 active:scale-95 text-white text-sm font-semibold transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16">
                        <path stroke-linecap="round" d="M8 3v10M3 8h10" />
                    </svg>
                    Create Post
                </a>

                @auth
                {{-- Desktop user dropdown --}}
                <div class="hidden sm:flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-150">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden lg:block">{{ Auth::user()->name }}</span>
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
                {{-- Desktop auth buttons --}}
                <div class="hidden sm:flex items-center gap-2 pl-2 border-l border-gray-100">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-150">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold transition-all duration-150">
                        Sign up
                    </a>
                </div>
                @endguest

                {{-- Hamburger (mobile only) --}}
                <button @click="open = !open"
                    class="sm:hidden flex flex-col justify-center gap-[5px] w-9 h-9 p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none"
                    aria-label="Toggle menu">
                    <span :class="open ? 'rotate-45 translate-y-[7px]' : ''"
                        class="block w-full h-[1.5px] bg-gray-600 transition-all duration-200 origin-center"></span>
                    <span :class="open ? 'opacity-0 scale-x-0' : ''"
                        class="block w-full h-[1.5px] bg-gray-600 transition-all duration-200"></span>
                    <span :class="open ? '-rotate-45 -translate-y-[7px]' : ''"
                        class="block w-full h-[1.5px] bg-gray-600 transition-all duration-200 origin-center"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="sm:hidden absolute inset-x-0 top-full bg-white border-b border-gray-100 shadow-lg z-50">

        <div class="px-4 py-3 space-y-0.5">

            {{-- Nav links --}}
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Home
            </a>

            @auth
            <a href="{{ route('post.following') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->routeIs('post.following') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                Following
            </a>
            <a href="{{ route('post.mypost') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->routeIs('post.mypost') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                My Posts
            </a>
            @endauth

            <a href="{{ route('category.create') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
            </a>

            <a href="{{ route('post.create') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Create Post
            </a>
        </div>

        {{-- Auth / User section --}}
        <div class="px-4 pb-4 pt-1 border-t border-gray-100">
            @guest
            <div class="flex flex-col gap-2 pt-3">
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center w-full py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Log in to your account
                </a>
                <a href="{{ route('register') }}"
                    class="flex items-center justify-center w-full py-2.5 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold transition-colors">
                    Create a free account
                </a>
            </div>
            @endguest

            @auth
            <div class="pt-3">
                <div class="flex items-center gap-3 px-3 py-2 mb-1">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-sm font-semibold shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors text-left">
                        Log Out
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>