<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Get all messages for the authenticated user, grouped by conversation.
     */
    public function index()
    {
        $userId = Auth::id();

        // This is a simple implementation. In a real app, you'd use a more optimized query 
        // to get the latest message per conversation.
        return Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();
    }

    /**
     * Get conversation with a specific user.
     */
    public function show($otherUserId)
    {
        $userId = Auth::id();

        return Message::where(function ($query) use ($userId, $otherUserId) {
                $query->where('sender_id', $userId)->where('receiver_id', $otherUserId);
            })
            ->orWhere(function ($query) use ($userId, $otherUserId) {
                $query->where('sender_id', $otherUserId)->where('receiver_id', $userId);
            })
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();
    }

    /**
     * Send a new message.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required_without:kitchen_id|exists:users,id',
            'body' => 'required|string',
            'kitchen_id' => 'required_without:receiver_id|exists:kitchens,id',
            'meta' => 'nullable|array',
        ]);

        $receiverId = $data['receiver_id'] ?? null;
        $kitchenId = $data['kitchen_id'] ?? null;

        if (!$receiverId && $kitchenId) {
            $kitchen = \App\Models\Kitchen::find($kitchenId);
            $receiverId = $kitchen->user_id;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'body' => $data['body'],
            'kitchen_id' => $kitchenId,
            'meta' => $data['meta'] ?? null,
        ]);

        return response()->json($message->load(['sender', 'receiver']), 201);
    }

    /**
     * Mark conversation as read.
     */
    public function markAsRead($otherUserId)
    {
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'Conversation marked as read']);
    }
}
