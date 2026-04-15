<?php

namespace App\Http\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class PublicProfileController extends Controller
{
    public function show(Request $request, User $user)
    {
        $posts = $user->posts()->latest()->paginate();
        // $user = User::all();
        return view('profile.show', compact('user', 'posts'));
        
    }
}
