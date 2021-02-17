<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\User;
use Auth;

/**
 * Class ConversationRepository
 *
 * @package App\Repositories
 */ 
class ConversationRepository
{
    public function get()
    {
        return Conversation::where('user1_id', Auth::user()->id)
            ->orWhere('user2_id', Auth::user()->id)
            ->withUsers()
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function store(User $user) 
    {
        if (Conversation::where('user1_id', Auth::user()->id)
            ->where('user2_id', $user->id)->count() ||
            Conversation::where('user1_id', $user->id)
            ->where('user2_id', Auth::user()->id)->count()) {
            return response()->json(['message' => 'Conversation with this user already exist.'], 422);
        } else {
            $conversation = Conversation::create([
                'user1_id' => Auth::user()->id,
                'user2_id' => $user->id,
            ]);

            return response()->json($conversation, 201);
        }
    }

    public function show(Conversation $conversation)
    {
        return $conversation->messages()
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function send(Conversation $conversation, $content)
    {
        return $conversation->messages()->create([
            'content' => $content,
            'user_id' => Auth::user()->id,
        ]);
    }
}
