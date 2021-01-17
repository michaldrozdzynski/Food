<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Comment $comment): bool
    {
        if ($user->id === $comment->user_id) {
            return true;
        } else {
            return false;
        }
    }

    public function rate(User $user, Comment $comment): bool
    {
        if ($comment->rates()->where('user_id', $user->id)->count() > 0) {
            return false;
        } else if ($comment->user_id === $user->id) {
            return false;
        } else {
            return true;
        }
    }
}
