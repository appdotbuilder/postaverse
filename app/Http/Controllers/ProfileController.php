<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return Inertia::render('profile/edit', [
            'mustVerifyEmail' => $request->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Display a user's public profile.
     */
    public function show(User $user)
    {
        $user->load(['followers', 'following']);

        $isFollowing = auth()->check() && 
                      auth()->user()->following()->where('following_id', $user->id)->exists();

        $posts = $user->posts()
                     ->with(['user', 'comments.user', 'likes'])
                     ->where('published_at', '!=', null)
                     ->where('published_at', '<=', now())
                     ->latest()
                     ->paginate(10);

        $postsCount = $user->posts()
                          ->where('published_at', '!=', null)
                          ->where('published_at', '<=', now())
                          ->count();

        return Inertia::render('profile/show', [
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => $isFollowing,
            'stats' => [
                'posts' => $postsCount,
                'followers' => $user->followers()->count(),
                'following' => $user->following()->count(),
            ]
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}