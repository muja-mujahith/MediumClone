<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClapController;

// Public routes
Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');
// Route::get('/', [PostController::class, 'index'])->name('dashboard');
// Route::get('/category/{category}', [PostController::class, 'byCategory'])->name('post.category');

Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/following', [PostController::class, 'following'])->name('post.following')->middleware('auth');
Route::get('/category/{category}', [PostController::class, 'byCategory'])->name('post.category');

// My Posts

// Post Edit / Update / Delete (auth protected)
Route::middleware('auth')->group(function () {
    Route::get('/@{username}/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/@{username}/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/@{username}/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    });
    
    // Post Create & Store
    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-posts', [PostController::class, 'myPost'])->name('post.mypost');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/@{username}/{post}', [PostController::class, 'show'])->name('post.show');

    Route::post('/follow/{user}', [FollowerController::class, 'followUnfollow'])->name('follow');
    Route::post('/clap/{post}', [ClapController::class, 'clap'])->name('clap');
});

require __DIR__ . '/auth.php';