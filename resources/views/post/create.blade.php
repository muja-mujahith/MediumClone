<x-app-layout>
    <div class="py-4 px-4 sm:py-8">
        <div class="max-w-2xl mx-auto">

            <div class="mb-6">
                <h1 class="text-xl font-semibold text-gray-900">Create Post</h1>
                <p class="text-sm text-gray-500 mt-1">Share something with the community</p>
            </div>

            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 flex flex-col gap-5 shadow-sm">
                @csrf

                {{-- Image upload --}}
                <div>
                    <x-input-label for="image" :value="__('Image')" class="mb-1.5" />

                    <label for="image" id="upload-label"
                           class="relative flex flex-col items-center justify-center w-full gap-2 cursor-pointer
                                  border-2 border-dashed border-gray-200 hover:border-indigo-400
                                  rounded-xl overflow-hidden text-center transition-colors duration-150
                                  bg-gray-50 hover:bg-indigo-50 min-h-[160px]">

                        {{-- Default placeholder (shown before image selected) --}}
                        <div id="upload-placeholder" class="flex flex-col items-center gap-2 py-8 px-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Tap to upload image</span>
                            <span class="text-xs text-gray-400">PNG, JPG, WEBP up to 10MB</span>
                        </div>

                        {{-- Image preview (hidden until file selected) --}}
                        <img id="image-preview"
                             src="#"
                             alt="Preview"
                             class="hidden w-full h-56 object-cover rounded-xl" />

                        {{-- Change overlay (shown on hover after image selected) --}}
                        <div id="change-overlay"
                             class="hidden absolute inset-0 bg-black/40 items-center justify-center rounded-xl">
                            <span class="text-white text-sm font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                Change image
                            </span>
                        </div>

                        <x-text-input id="image" class="sr-only" type="file"
                                      name="image" accept="image/*"
                                      :value="old('image')" required />
                    </label>

                    {{-- File name --}}
                    <p id="file-name" class="mt-1.5 text-xs text-gray-400 hidden"></p>

                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                {{-- Title --}}
                <div>
                    <x-input-label for="title" :value="__('Title')" class="mb-1.5" />
                    <x-text-input id="title" class="block w-full" type="text"
                                  name="title" :value="old('title')"
                                  placeholder="Enter post title…"
                                  required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Category --}}
                <div>
                    <x-input-label for="category_id" :value="__('Category')" class="mb-1.5" />
                    <select id="category_id" name="category_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                   rounded-xl shadow-sm block w-full text-sm py-2.5 px-3
                                   bg-white appearance-none">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                {{-- Content --}}
                <div>
                    <x-input-label for="content" :value="__('Content')" class="mb-1.5" />
                    <x-input-textarea id="content"
                                      class="block w-full min-h-[160px] sm:min-h-[220px] resize-y"
                                      name="content"
                                      placeholder="Write your post content here…"
                                      required autofocus>{{ old('content') }}</x-input-textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row-reverse gap-3 pt-1">
                    <x-primary-button class="w-full sm:w-auto justify-center py-2.5">
                        Publish Post
                    </x-primary-button>
                    <a href="{{ route('dashboard') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5
                              rounded-lg border border-gray-200 text-sm font-medium text-gray-600
                              hover:bg-gray-50 transition-colors text-center">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        const imageInput      = document.getElementById('image');
        const imagePreview    = document.getElementById('image-preview');
        const placeholder     = document.getElementById('upload-placeholder');
        const changeOverlay   = document.getElementById('change-overlay');
        const fileNameLabel   = document.getElementById('file-name');
        const uploadLabel     = document.getElementById('upload-label');

        imageInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                // Show preview image
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');

                // Hide the placeholder icon/text
                placeholder.classList.add('hidden');

                // Remove dashed border styling now that image fills it
                uploadLabel.classList.remove('border-dashed', 'bg-gray-50', 'hover:bg-indigo-50');
                uploadLabel.classList.add('border-solid', 'border-indigo-300');

                // Show change overlay on hover
                changeOverlay.classList.remove('hidden');
                changeOverlay.classList.add('flex');

                // Show filename below
                fileNameLabel.textContent = file.name;
                fileNameLabel.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        });

        // Show/hide overlay on hover
        uploadLabel?.addEventListener('mouseenter', () => {
            if (!imagePreview.classList.contains('hidden')) {
                changeOverlay.style.display = 'flex';
            }
        });
        uploadLabel?.addEventListener('mouseleave', () => {
            changeOverlay.style.display = 'none';
        });
    </script>
</x-app-layout>