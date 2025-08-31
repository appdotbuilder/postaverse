<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Welcome page
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Dashboard with news feed
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $posts = Post::with(['user', 'comments.user', 'likes.user'])
            ->published()
            ->public()
            ->latest()
            ->paginate(10);

        return Inertia::render('dashboard', [
            'posts' => $posts
        ]);
    })->name('dashboard');
});

// Posts routes
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
    
    // Post interactions
    Route::post('/posts/{post}/like', function (Post $post) {
        $user = auth()->user();
        
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
            $post->decrement('likes_count');
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $post->increment('likes_count');
        }
        
        return back();
    })->name('posts.like');
});

// Groups routes
Route::middleware(['auth'])->group(function () {
    Route::resource('groups', GroupController::class);
    Route::post('/groups/{group}/members', [GroupMemberController::class, 'store'])->name('groups.join');
    Route::delete('/groups/{group}/members', [GroupMemberController::class, 'destroy'])->name('groups.leave');
});

// Messages routes
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Public profile views
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');
    Route::post('/users/follow', [UserController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [UserController::class, 'destroy'])->name('users.unfollow');
});

// Public routes for browsing
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';