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
    public function get(FoodRecipe $foodRecipe)
    {
        $comments = $foodRecipe->comments()
            ->select([
                'id',
                'food_recipe_id',
                'user_id',
                'content',
                'points',
                'created_at',
            ])
            ->withUserName()
            ->get();
        
        $deletedComments = $foodRecipe->comments()
            ->onlyTrashed()
            ->select([
                'id',
                'food_recipe_id',
                'deleted_at',
            ])
            ->get();

        return [
            'comments' => $comments,
            'deletedComments' => $deletedComments,
        ];
    }

    public function store(array $data, FoodRecipe $foodRecipe)
    {
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

        return response()->json($foodRecipe->comments()->create($commentData), 201);
    }

    public function plus(Comment $comment)
    {
        $user = Auth::user();

        $comment->increment('points');
        $comment->save();

        $comment->rates()->create([
            'user_id' => $user->id,
            'rating' => 1,
        ]);

        return $comment;
    }

    public function minus(Comment $comment)
    {
        $user = Auth::user();

        $comment->decrement('points');
        $comment->save();

        $comment->rates()->create([
            'user_id' => $user->id,
            'rating' => -1,
        ]);

        return $comment;
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return 'Success. You have deleted this comment.';
    }
}
