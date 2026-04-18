<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:p-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('post.update', [$post->user->username, $post->slug]) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image -->
                <div>
                    <x-input-label for="image" :value="__('Image')" />

                    @if ($post->image)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 alt="Current image" 
                                 class="h-40 w-auto rounded-lg object-cover" />
                            <p class="text-xs text-gray-500 mt-1">Current image — upload a new one to replace it.</p>
                        </div>
                    @endif

                    <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Title -->
                <div class="mt-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" 
                                  :value="old('title', $post->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Category -->
                <div class="mt-4">
                    <x-input-label for="category_id" :value="__('Category')" />
                    <select id="category_id" name="category_id" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <x-input-label for="content" :value="__('Content')" />
                    <x-input-textarea id="content" class="block mt-1 w-full" name="content" required autofocus>
                        {{ old('content', $post->content) }}
                    </x-input-textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex gap-3 mt-4">
                    <x-primary-button>Update Post</x-primary-button>
                    <a href="{{ route('post.mypost') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

