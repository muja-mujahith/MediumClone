

<ul class="flex flex-wrap text-sm font-medium text-center justify-center">
    <li class="me-2">
        <a href="/" 
           class="{{ !request()->route('category')
                ? 'inline-block px-4 py-2 text-white bg-green-600 rounded-lg' 
                : 'inline-block px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200' }}">
            All
        </a>
    </li>

    @forelse ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.category',  $category) }}" 
               class="{{ request()->route('category') && request()->route('category')->id == $category->id
                    ? 'inline-block px-4 py-2 text-white bg-green-600 rounded-lg' 
                    : 'inline-block px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200' }}">
                {{ $category->name }}
            </a>
        </li>
    @empty
        <li>No categories found.</li>
    @endforelse
</ul>