<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tabs -->
                    <ul class="flex flex-wrap text-sm font-medium text-center justify-center">
                        <x-category-tabs>
                            No Categories
                        </x-category-tabs>
                    </ul>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                    @empty
                    <div class="text-center text-red-50">No Post Found.</div>
                    @endforelse

                </div>

                {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>