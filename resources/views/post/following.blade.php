<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <x-category-tabs />
                </div>
            </div>

            <div class="mt-8">
                <div class="p-4 text-gray-900">
                    @forelse($posts as $post)
                        <x-post-item :post="$post" />
                    @empty
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            	        </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-700">No posts yet</h3>
                            <p class="mt-2 text-gray-500">You're not following anyone yet, or the people you follow haven't posted.</p>
                            <a href="{{ route('dashboard') }}"
                               class="mt-6 inline-block px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Discover People
                            </a>
                        </div>
                    @endforelse
                </div>

                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-app-layout>