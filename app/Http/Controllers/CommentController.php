<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Http\Requests\StoreComment;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    private $comments;

    public function __construct(CommentRepository $commentRepository) 
    {
        $this->comments = $commentRepository;
    }

    public function index(int $id): JsonResponse
    {   
        return response()->json($this->comments->get($id));
    }

    public function store(StoreComment $request): JsonResponse
    {
        return $this->comments->store($request->validated());
    }

    public function good(Comment $comment): JsonResponse
    {
        return response()->json($this->comments->plus($comment->id));
    }

    public function bad(Comment $comment): JsonResponse
    {
        return response()->json($this->comments->minus($comment->id));
    }
}
