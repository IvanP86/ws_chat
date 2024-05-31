<?php

namespace App\Actions;

use App\DTO\MessageDTObuilder;
use App\Models\Message;

final class StoreMessageAction
{
    public function handle(MessageDTObuilder $data): Message
    {
        $message = Message::create([
            'chat_id' => $data->chat_id,
            'user_id' => auth()->id(),
            'body' => $data->body
        ]);
        return $message;
    }
}