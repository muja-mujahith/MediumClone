<div style="transition: border-color 0.15s;"
     class="bg-white border border-gray-200 rounded-xl overflow-hidden flex hover:border-gray-300 mb-6">

    {{-- Content --}}
    <div class="flex-1 p-5 flex flex-col justify-between gap-3">

        <div>
            {{-- Category + Date --}}
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-medium bg-green-100 text-green-700 px-3 py-0.5 rounded-full">
                    {{ $post->category->name ?? 'General' }}
                </span>
                <span class="text-xs text-gray-400">{{ $post->created_at->format('M d, Y') }}</span>
            </div>

            {{-- Title --}}
            <a href="{{ route('post.show', ['post' => $post->slug, 'username' => $post->user->username]) }}">
                <h2 class="text-base font-medium text-gray-900 leading-snug mb-2 hover:text-green-700 transition-colors">
                    {{ $post->title }}
                </h2>
            </a>

            {{-- Excerpt --}}
            <p class="text-sm text-gray-500 leading-relaxed">
                {{ Str::words($post->content, 15) }}
            </p>
        </div>

        {{-- Footer: author + claps + read more --}}
        <div class="flex items-center justify-between mt-1">

            {{-- Author --}}
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-medium flex items-center justify-center">
                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                </div>
                <span class="text-sm text-gray-500">{{ $post->user->name }}</span>
            </div>

            <div class="flex items-center gap-3">
                {{-- Claps --}}
                <div class="flex items-center gap-1 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                    <span class="text-sm">{{ $post->claps()->count() }}</span>
                </div>

                {{-- Read more --}}
                <a href="{{ route('post.show', ['post' => $post->slug, 'username' => $post->user->username]) }}"
                   class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-800 border border-gray-300 rounded-lg px-3 py-1 hover:bg-gray-50 transition-colors">
                    Read more
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>

    {{-- Thumbnail --}}
    <a href="{{ route('post.show', ['post' => $post->slug, 'username' => $post->user->username]) }}"
       class="w-36 flex-shrink-0">
        <img class="w-full h-full object-cover" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" />
    </a>

</div>