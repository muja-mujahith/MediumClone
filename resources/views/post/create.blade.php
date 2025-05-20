<x-app-layout>


    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:p-8">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- image  -->
                <div>
                    <x-input-label for="image" :value="__('Image')" />

                    <!-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label> -->
                    <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" :value="old('image')" required autofocus />

                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <!-- title  -->
                <div class="mt-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- category  -->
                <div class="mt-4">
                    <x-input-label for="category_id" :value="__('Category')" />
                    <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        <option value="" >Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <!-- content  -->
                <div class="mt-4">
                    <x-input-label for="content" :value="__('Content')" />
                    <x-input-textarea id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required autofocus></x-input-textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <x-primary-button class="mt-4">Submit</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>


