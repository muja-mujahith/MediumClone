<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Posts</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($posts as $post)
            <div class="bg-white rounded-lg shadow p-5 mb-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <a href="{{ route('post.show', [$post->user->username, $post->slug]) }}" 
                           class="hover:text-green-600">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <span class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($post->body, 150) }}</p>

                <div class="flex gap-3 mt-4">
                    <a href="{{ route('post.edit', [$post->user->username, $post->slug]) }}"
                       class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                        Edit
                    </a>

                    <form action="{{ route('post.destroy', [$post->user->username, $post->slug]) }}" 
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-sm px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-12">
                <p class="text-lg">You haven't created any posts yet.</p>
                <a href="{{ route('post.create') }}" 
                   class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Create your first post
                </a>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>