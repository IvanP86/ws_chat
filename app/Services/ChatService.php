<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class ChatService
{
    public function transformChatsTitleAndCountUreadableMessages($chats): Collection
    {
        $chats->transform(function ($chat) {
            if (!$chat->title) {
                $chat->title = 'With ' . $chat->chatUsers()->where('user_id', '!=', auth()->id())->implode('name', ',');
            }
            $chat->unreadable_message_statuses_count = $chat->messageStatuses()->where('user_id', auth()->id())->where('is_read', false)->count();
            return $chat;
        });
        return $chats;
    }

    public function readMessages($chat): void
    {
        $chat->messageStatuses()->where('user_id', auth()->id())->where('is_read', false)->update([
            'is_read' => true
        ]);
    }
}
