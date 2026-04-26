<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

        {{-- Success toast --}}
        @if (session('success'))
            <div class="flex items-center gap-2 mb-5 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 gap-3">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">My Posts</h1>
            <a href="{{ route('post.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Post
            </a>
        </div>

        @forelse ($posts as $post)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-4 hover:border-gray-300 transition-colors">

                {{-- Card top: thumbnail + info --}}
                <div class="flex gap-3 p-4">

                    {{-- Thumbnail --}}
                    @if ($post->image)
                        <a href="{{ route('post.show', [$post->user->username, $post->slug]) }}"
                           class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover">
                        </a>
                    @else
                        <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 19.5h18"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex-1 min-w-0 flex flex-col gap-1">
                        {{-- Category + time --}}
                        <div class="flex items-center gap-2 flex-wrap">
                            @if ($post->category)
                                <span class="text-[11px] font-medium bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <span class="text-[11px] text-gray-400">
                                {{ $post->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <a href="{{ route('post.show', [$post->user->username, $post->slug]) }}"
                           class="text-sm sm:text-[15px] font-medium text-gray-900 hover:text-green-700 transition-colors leading-snug line-clamp-2">
                            {{ $post->title }}
                        </a>

                        {{-- Excerpt (hidden on very small screens) --}}
                        <p class="hidden xs:block text-xs text-gray-500 leading-relaxed line-clamp-2">
                            {{ Str::limit($post->content ?? $post->body ?? '', 100) }}
                        </p>
                    </div>
                </div>

                {{-- Card footer: stats + actions --}}
                <div class="flex items-center justify-between px-4 py-2.5 border-t border-gray-100 bg-gray-50">

                    {{-- Claps count --}}
                    <div class="flex items-center gap-1 text-gray-400 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V2.75a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375Z"/>
                        </svg>
                        {{ $post->claps()->count() }} claps
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('post.edit', [$post->user->username, $post->slug]) }}"
                           class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('post.destroy', [$post->user->username, $post->slug]) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this post? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="flex flex-col items-center justify-center text-center py-16 px-6">
                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <h2 class="text-base font-semibold text-gray-900 mb-1">No posts yet</h2>
                <p class="text-sm text-gray-500 mb-5">Share your ideas with the community</p>
                <a href="{{ route('post.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create your first post
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</x-app-layout>