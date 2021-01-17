<?php

namespace App\Http\Controllers;

use App\Repositories\ConversationRepository;
use App\Models\User;
use App\Models\Conversation;
use App\Http\Requests\SendMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    private $conversations;

    public function __construct(ConversationRepository $conversationRepository) 
    {
        $this->conversations = $conversationRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->conversations->get());
    }

    public function store(User $user): JsonResponse
    {
        return $this->conversations->store($user);
    }

    public function show(Conversation $conversation): JsonResponse
    {
        $this->authorize('view', $conversation);

        return response()->json($this->conversations->show($conversation));
    }

    public function send(Conversation $conversation, SendMessage $request)
    {
        $this->authorize('send', $conversation);

        return response()->json($this->conversations->send($conversation, $request->content), 201);
    }
}
