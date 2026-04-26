<x-app-layout>
    <div class="max-w-xl max-h-screen mx-auto py-10 px-4 mt-10">

        <div class="bg-white shadow rounded-xl p-6 mt-10">
            <h1 class="text-xl font-bold text-gray-800 mb-6">
                Add New Category
            </h1>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                {{-- Category Name --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category Name
                    </label>

                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. Laravel, Docker, DevOps"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-black rounded-lg 
                                   hover:bg-indigo-700 transition">
                        Save Category
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>