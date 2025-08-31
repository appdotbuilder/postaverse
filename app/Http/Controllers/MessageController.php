<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of message conversations.
     */
    public function index()
    {
        $userId = auth()->id();
        
        // Get unique conversations with latest message
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with(['sender', 'recipient'])
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id === $userId 
                    ? $message->recipient_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            })
            ->values();

        return Inertia::render('messages/index', [
            'conversations' => $conversations
        ]);
    }

    /**
     * Display messages with a specific user.
     */
    public function show(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                  ->where('recipient_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('recipient_id', auth()->id());
        })
        ->with(['sender', 'recipient'])
        ->orderBy('created_at')
        ->get();

        // Mark messages from the other user as read
        Message::where('sender_id', $user->id)
            ->where('recipient_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return Inertia::render('messages/show', [
            'user' => $user,
            'messages' => $messages
        ]);
    }

    /**
     * Store a new message.
     */
    public function store(StoreMessageRequest $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'content' => $request->content,
            'media' => $request->media,
        ]);

        return redirect()->route('messages.show', $request->recipient_id)
            ->with('success', 'Message sent successfully!');
    }
}