<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of groups.
     */
    public function index()
    {
        $groups = Group::with(['creator'])
            ->withCount('members')
            ->where('is_active', true)
            ->where('privacy', 'public')
            ->latest()
            ->paginate(12);

        return Inertia::render('groups/index', [
            'groups' => $groups
        ]);
    }

    /**
     * Show the form for creating a new group.
     */
    public function create()
    {
        return Inertia::render('groups/create');
    }

    /**
     * Store a newly created group.
     */
    public function store(StoreGroupRequest $request)
    {
        $group = auth()->user()->createdGroups()->create($request->validated());
        
        // Add creator as admin member
        DB::table('group_members')->insert([
            'group_id' => $group->getKey(),
            'user_id' => auth()->id(),
            'role' => 'admin',
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('groups.show', $group)
            ->with('success', 'Group created successfully!');
    }

    /**
     * Display the specified group.
     */
    public function show(Group $group)
    {
        $group->load(['creator']);

        $isMember = $group->members()->where('user_id', auth()->id())->exists();

        return Inertia::render('groups/show', [
            'group' => $group,
            'isMember' => $isMember
        ]);
    }

    /**
     * Show the form for editing the group.
     */
    public function edit(Group $group)
    {
        if ($group->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('groups/edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified group.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        if ($group->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $group->update($request->validated());

        return redirect()->route('groups.show', $group)
            ->with('success', 'Group updated successfully!');
    }

    /**
     * Remove the specified group.
     */
    public function destroy(Group $group)
    {
        if ($group->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $group->delete();

        return redirect()->route('groups.index')
            ->with('success', 'Group deleted successfully!');
    }
}