<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of posts for the news feed.
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes.user'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('privacy', 'public')
            ->latest()
            ->paginate(10);

        return Inertia::render('posts/index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return Inertia::render('posts/create');
    }

    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create([
            ...$request->validated(),
            'published_at' => now(),
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'comments.replies.user', 'likes.user']);

        return Inertia::render('posts/show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the post.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('posts/edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified post.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $post->update($request->validated());

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Post deleted successfully!');
    }
}