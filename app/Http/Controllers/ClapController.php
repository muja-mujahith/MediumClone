<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class ClapController extends Controller
{
  public function clap(Post $post)
{
    $existing = $post->claps()->where('user_id', auth()->id())->first();

    if ($existing) {
        $existing->delete();
    } else {
        $post->claps()->create(['user_id' => auth()->id()]);
    }

    return response()->json([
        'count' => $post->claps()->count(),
    ]);
}
}
