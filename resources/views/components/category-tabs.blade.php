@php
    $activeCategory = request('category');
@endphp

<div class="relative">

    {{-- fade edges --}}
    <div class="absolute left-0 top-0 bottom-0 w-6 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none sm:hidden"></div>
    <div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none sm:hidden"></div>

    <div class="flex gap-1.5 overflow-x-auto scrollbar-hide px-4 sm:px-0 sm:flex-wrap sm:justify-center pb-1">

        {{-- ALL --}}
        <a href="{{ url()->current() }}"
           class="shrink-0 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap
           {{ !$activeCategory ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">
            All
        </a>

        {{-- categories --}}
        @foreach ($categories as $cat)
            <a href="{{ url()->current() }}?category={{ $cat->slug }}"
               class="shrink-0 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap
               {{ $activeCategory === $cat->slug
                    ? 'bg-green-600 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">
                {{ $cat->name }}
            </a>
        @endforeach

    </div>
</div>