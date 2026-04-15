<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Container\Attributes\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Post::orderBy('created_at', 'DESC')->paginate(6);
        // $categories = Category::get();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', compact('categories'));
        // return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        // return view('post.store');
        $data = $request->validated();

        $image = $data['image'];
        unset($data['image']);
        $data['user_id'] = auth()->id();
        $imagePath = $image->store('posts', 'public');
        $data['image'] = $imagePath;
        $data['slug'] = Str::slug($data['title']);
        Post::create($data);
        return redirect()->route('dashboard');
    }

    /**~
     * Display the specified resource.
     */
    // public function show(string $username, Post $post)
    // {
    //     $post = Post::where('slug', $post)
    //     ->whereHas('user', function ($query) use ($username) {
    //         $query->where('username', $username);
    //     })
    //     ->firstOrFail();

    // return view('post.show', compact('post'));
    // }

    public function show(string $username, string $post)
    {
        // $user = auth()->user();
        // dd($user->following);
        $post = Post::where('slug', $post)
            ->whereHas('user', function ($query) use ($username) {
                $query->where('username', $username);
            })
            ->firstOrFail();

        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
