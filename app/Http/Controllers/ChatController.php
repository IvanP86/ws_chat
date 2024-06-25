<?php

namespace App\Http\Controllers;

use App\Actions\CreateChatAction;
use App\DTO\ChatDTObuilder;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\User\UserResource;
use App\Models\Chat;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct(public readonly CreateChatAction $createChatAction, public readonly UserService $userService, public readonly ChatService $chatService)
    {
    }
    public function index()
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        $users = $this->userService->getAnotherUsers($user->id);
        $chats = $user->getUserChats();
        $chats = $this->chatService->transformChatsTitleAndCountUreadableMessages($chats, $user->id);
        $chats = ChatResource::collection($chats)->resolve();

        return inertia('Chat/Index', compact('users', 'chats'));
    }

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
        $this->chatService->readMessages($chat, auth()->id());
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
