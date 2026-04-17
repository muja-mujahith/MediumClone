<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 justify-center">
    <li class="me-2">
        <a href="#" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active" aria-current="page">All</a>
    </li>
    @forelse ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.category', $category) }}" 
            class= "{{ Route::currentRouteNamed('post.category') && request('category') == $category->id }}" ? 
            'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:text-white'
            >{{ $category->name }}</a>
        </li>   
    @empty
        {{ $slot }}
    @endforelse


</ul>