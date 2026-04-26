<x-app-layout>
    <div class="min-h-screen py-4 px-4 sm:px-6 lg:px-8 flex justify-center">

        <div class="w-full max-w-2xl bg-white shadow-md rounded-2xl p-5 sm:p-6">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-5">
                Edit Post
            </h2>

            <form action="{{ route('post.update', [$post->user->username, $post->slug]) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-5">

                @csrf
                @method('PUT')

                <!-- Image -->
                <div>
                    <x-input-label for="image" value="Image" />

                    @if ($post->image)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="Current image"
                                 class="w-full max-h-56 object-cover rounded-lg" />

                            <p class="text-xs text-gray-500 mt-1">
                                Current image — upload a new one to replace it.
                            </p>
                        </div>
                    @endif

                    <x-text-input id="image"
                        class="block mt-1 w-full text-sm"
                        type="file"
                        name="image" />

                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Title" />

                    <x-text-input id="title"
                        class="block mt-1 w-full"
                        type="text"
                        name="title"
                        :value="old('title', $post->title)"
                        required />

                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <!-- Category -->
                <div>
                    <x-input-label for="category_id" value="Category" />

                    <select id="category_id" name="category_id"
                        class="block mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        
                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                </div>

                <!-- Content -->
                <div>
                    <x-input-label for="content" value="Content" />

                    <x-input-textarea id="content"
                        class="block mt-1 w-full min-h-[120px]"
                        name="content"
                        required>
                        {{ old('content', $post->content) }}
                    </x-input-textarea>

                    <x-input-error :messages="$errors->get('content')" class="mt-1" />
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <x-primary-button class="w-full sm:w-auto justify-center">
                        Update Post
                    </x-primary-button>

                    <a href="{{ route('post.mypost') }}"
                       class="w-full sm:w-auto text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
                        Cancel
                    </a>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>