<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Conversation $conversation): bool
    {
        if ($conversation->user1_id === $user->id || $conversation->user2_id === $user->id) {
            return true;
        } else {
            return false;
        } 
    }

    public function send(User $user, Conversation $conversation): bool
    {
        if ($conversation->user1_id === $user->id || $conversation->user2_id === $user->id) {
            return true;
        } else {
            return false;
        } 
    }
}
