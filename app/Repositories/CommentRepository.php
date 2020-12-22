<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\CommentRate;
use App\Models\FoodRecipe;
use Auth;

/**
 * Class CommentRepository
 *
 * @package App\Repositories
 */ 
class CommentRepository
{
    public function get(int $id)
    {
        return Comment::where('food_recipe_id', $id)->get();
    }

    public function store(array $data)
    {
        $foodRecipe = FoodRecipe::find($data['food_recipe_id']);
        if (isset($data['parent_id']) && $foodRecipe->comments()->find($data['parent_id']) === null) {
            return response()->json([
                'message' => "The given data was invalid.",
                'errors' => [
                    'parent_id' => "The selected parent id is invalid",
                ], 
            ],422);
        }
        $commentData = [
            'user_id' => Auth::user()->id,
            'content' => $data['content'],
            'parent_id' => $data['parent_id'] ?? null,
        ];

        return response()->json($foodRecipe->comments()->create($commentData),201);
    }

    public function plus(int $id)
    {
        $user = Auth::user();
        $comment = Comment::find($id);

        if ($user->id == $comment->user_id) {
            return "You cannot rate yours comments.";
        } else if (CommentRate::where('comment_id', $comment->id)->where('user_id', $user->id)->count()) {
            return "You rated this comment before.";
        } else {
            $comment->increment('points');
            $comment->save();

            CommentRate::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id,
                'rating' => 1,
            ]);

            return $comment;
        }
    }

    public function minus(int $id)
    {
        $user = Auth::user();
        $comment = Comment::find($id);

        if ($user->id == $comment->user_id) {
            return "You cannot rate yours comments.";
        } else if (CommentRate::where('comment_id', $comment->id)->where('user_id', $user->id)->count()) {
            return "You rated this comment before.";
        } else {
            $comment->decrement('points');
            $comment->save();

            CommentRate::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id,
                'rating' => -1,
            ]);

            return $comment;
        }
    }
}
