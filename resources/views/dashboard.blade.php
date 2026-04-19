<x-app-layout>
    <div style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding: 2rem;">

        <!-- Book icon -->
        <svg width="48" height="48" viewBox="0 0 52 52" fill="none" style="opacity:0.2; margin-bottom:1.5rem;">
            <path d="M8 10C8 8.9 8.9 8 10 8h14v36H10C8.9 44 8 43.1 8 42V10z" fill="currentColor"/>
            <path d="M28 8h14c1.1 0 2 .9 2 2v32c0 1.1-.9 2-2 2H28V8z" fill="currentColor" opacity="0.5"/>
        </svg>

        <h1 class="text-4xl font-serif font-normal mb-3">
            A place to read things that <em class="opacity-50">matter</em>
        </h1>

        <p class="text-gray-400 font-light mb-8 max-w-xs leading-relaxed">
            Stories, ideas, and expertise from writers on any topic.
        </p>

        <a href="{{ route('posts.index') }}"
           class="px-7 py-3 bg-black text-white rounded-full text-sm hover:bg-gray-800 transition">
            Start Reading
        </a>

        <!-- Topic pills -->
        <div class="flex flex-wrap gap-2 justify-center mt-8">
            @foreach(['Technology','Culture','Science','Health','Design','Business'] as $topic)
                <span class="text-xs text-gray-400 border border-gray-200 rounded-full px-3 py-1">{{ $topic }}</span>
            @endforeach
        </div>

    </div>
</x-app-layout>