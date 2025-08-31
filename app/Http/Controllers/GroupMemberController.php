<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    /**
     * Join a group.
     */
    public function store(Group $group)
    {
        if ($group->members()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You are already a member of this group.');
        }

        $group->members()->attach(auth()->id(), [
            'role' => 'member',
            'status' => $group->privacy === 'private' ? 'pending' : 'approved'
        ]);

        $message = $group->privacy === 'private' 
            ? 'Join request sent! Waiting for approval.'
            : 'You have joined the group successfully!';

        return back()->with('success', $message);
    }

    /**
     * Leave a group.
     */
    public function destroy(Group $group)
    {
        $group->members()->detach(auth()->id());

        return back()->with('success', 'You have left the group.');
    }
}