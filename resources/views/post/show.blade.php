<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>
                <!-- user avatar -->
                <div class="flex gap-4">
                    @if($post->user->image)
                    <img src="{{ Storage::url($post->user->image) }}" alt="{{ $post->user->username }}" class="h-12 w-12 rounded-full">
                    @else
                    <img src="https://i.pinimg.com/originals/54/72/d1/5472d1b09d3d724228109d381d617326.jpg" alt="diummy image">
                    @endif

                    <div>
                        <div class="flex gap-2">
                            <h3>{{ $post->user->name }}</h3>
                            &middot;
                            <a href="*" class="text-emerald-600">Follow</a>
                        </div>
                        <div class="flex gap-2 text-sm text-gray-500">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                <!-- end of user avatar -->

                <!-- clap section -->
                <x-clap-button />
                <!-- end of clap section -->
                

                
                <!-- content section -->
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full" />
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>
                <!--end of contetn secton  -->

                <div class="mt-8">
                    <span class="p-2 bg-gray-300 rounded-2xl">{{ $post->category->name }}</span>
                </div>

                
                <!-- clap section -->
                <x-clap-button />
                <!-- end of clap section -->
            </div>
        </div>
    </div>
</x-app-layout>