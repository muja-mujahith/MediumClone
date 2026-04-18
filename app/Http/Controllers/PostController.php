<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Home page — all posts for everyone
    public function index()
    {
        $categories = Category::all();

        $posts = Post::with(['user', 'category'])
            ->withCount('claps')
            ->latest()
            ->paginate(10);

        return view('post.index', compact('posts', 'categories'));
    }

    // Following page — only posts from followed users
    public function following()
    {
        $categories = Category::all();

        $followingIds = auth()->user()->following()->pluck('users.id');

        $posts = Post::whereIn('user_id', $followingIds)
            ->with(['user', 'category'])
            ->withCount('claps')
            ->latest()
            ->paginate(10);

        return view('post.following', compact('posts', 'categories'));
    }

    // Category — all posts in category
    public function byCategory(Category $category)
    {
        $categories = Category::all();

        $posts = Post::where('category_id', $category->id)
            ->with(['user', 'category'])
            ->withCount('claps')
            ->latest()
            ->paginate(10);

        return view('post.index', compact('posts', 'categories', 'category'));
    }

    // My Posts
   public function myPost()
{
    $posts = Post::where('user_id', auth()->id())
        ->with(['user', 'category'])  // ← 'user' is required for $post->user->username
        ->latest()
        ->paginate(10);

    return view('post.myposts', compact('posts'));
}

    // Create post form
    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    // Store new post
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();

        $image = $data['image'];
        unset($data['image']);

        $data['user_id'] = auth()->id();
        $data['image']   = $image->store('posts', 'public');
        $data['slug']    = Str::slug($data['title']);

        Post::create($data);

        return redirect()->route('post.mypost')->with('success', 'Post created successfully.');
    }

    // Show single post
    public function show(string $username, string $post)
    {
        $post = Post::where('slug', $post)
            ->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            })
            ->firstOrFail();

        return view('post.show', compact('post'));
    }

    // Edit post form
    public function edit(string $username, string $post)
    {
        $post = Post::where('slug', $post)
            ->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            })
            ->firstOrFail();

        abort_if($post->user_id !== auth()->id(), 403);

        $categories = Category::all();

        return view('post.edit', compact('post', 'categories'));
    }

    // Update post
    public function update(Request $request, string $username, string $post)
    {
        $post = Post::where('slug', $post)
            ->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            })
            ->firstOrFail();

        abort_if($post->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',   // ← content not body
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        $post->update($validated);

        return redirect()
            ->route('post.show', [auth()->user()->username, $post->slug])
            ->with('success', 'Post updated successfully.');
    }

    // Delete post
    public function destroy(string $username, string $post)
    {
        $post = Post::where('slug', $post)
            ->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            })
            ->firstOrFail();

        abort_if($post->user_id !== auth()->id(), 403);

        $post->delete();

        return redirect()
            ->route('post.mypost')
            ->with('success', 'Post deleted successfully.');
    }

    // Category page (public - no follow filter)
    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', compact('posts'));
    }
}
