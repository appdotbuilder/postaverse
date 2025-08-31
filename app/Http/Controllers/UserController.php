<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Follow a user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'following_id' => 'required|exists:users,id|different:' . auth()->id(),
        ]);

        $user = User::findOrFail($request->following_id);
        
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $follower = auth()->user();
        
        if ($follower->following()->where('following_id', $user->id)->exists()) {
            return back()->with('error', 'You are already following this user.');
        }

        $follower->following()->attach($user->id, [
            'status' => $user->privacy === 'private' ? 'pending' : 'approved'
        ]);

        $message = $user->privacy === 'private' 
            ? 'Follow request sent!'
            : 'You are now following ' . $user->name;

        return back()->with('success', $message);
    }

    /**
     * Unfollow a user.
     */
    public function destroy(User $user)
    {
        auth()->user()->following()->detach($user->id);

        return back()->with('success', 'You are no longer following ' . $user->name);
    }
}