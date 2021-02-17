<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Http\Requests\StoreComment;
use App\Models\Comment;
use App\Models\FoodRecipe;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    private $comments;

    public function __construct(CommentRepository $commentRepository) 
    {
        $this->comments = $commentRepository;
    }

    public function index(FoodRecipe $recipe): JsonResponse
    {   
        return response()->json($this->comments->get($recipe));
    }

    public function store(StoreComment $request, FoodRecipe $recipe): JsonResponse
    {
        return $this->comments->store($request->validated(), $recipe);
    }

    public function checkRate(Comment $comment) {
        if ($comment->user_id === auth()->user()->id) {
            return response()->json(false);
        } else if ($comment->rates()->where('user_id', auth()->user()->id)->count() > 0) {
            return (response()->json(false));
        }   else {
            return response()->json(true);
        }  
    }

    public function good(Comment $comment): JsonResponse
    {
        $this->authorize('rate', $comment);

        return response()->json($this->comments->plus($comment));
    }

    public function bad(Comment $comment): JsonResponse
    {
        $this->authorize('rate', $comment);

        return response()->json($this->comments->minus($comment));
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        return response()->json($this->comments->delete($comment), 204); 
    }
}
