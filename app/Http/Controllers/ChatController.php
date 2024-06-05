<?php

namespace App\Http\Controllers;

use App\Actions\CreateChatAction;
use App\DTO\ChatDTObuilder;
use App\Http\Requests\Chat\StoreRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\User\UserResource;
use App\Models\Chat;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct(public readonly CreateChatAction $createChatAction, public readonly UserService $userService)
    {
    }
    public function index()
    {
        $users = $this->userService->getAnotherUsers();
        $chats = auth()->user()->getUserChats();
        $chats = ChatResource::collection($chats)->resolve();
        return inertia('Chat/Index', compact('users', 'chats'));
    }

    // public function store(Request $request, ChatDTObuilder $builder)
    public function store(Request $request, ChatDTObuilder $builder)
    {
        $data = $builder->from($request);

        return redirect()->route('chats.show', $this->createChatAction->handle($data));
    }

    public function show(Chat $chat)
    {
        $page = request('page') ?? 1;
        $users = $chat->getUsers();
        $messages = $chat->getMessagesWithPagination($page);
        $chat->readMessages();
        $isLastPage = $messages->onLastPage();
        $messages = MessageResource::collection($messages)->resolve();
        if ($page > 1) {
            return response()->json([
                'is_last_page' => $isLastPage,
                'messages' => $messages
            ]);
        }
        $users = UserResource::collection($users)->resolve();
        $chat = ChatResource::make($chat)->resolve();
        return inertia('Chat/Show', compact('chat', 'users', 'messages', 'isLastPage'));
    }
}
