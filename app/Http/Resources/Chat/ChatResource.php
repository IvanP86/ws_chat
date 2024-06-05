<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? 'With ' . $this->chatWith()->where('user_id', '!=', auth()->id())->implode('name', ', '),
            'users' => $this->users,
            // 'chat_with' => $this->chatWith->name,
            'chat_with' => $this->chatWith()->where('user_id', '!=', auth()->id())->implode('name', ', '),
            'last_message' => isset($this->lastMessage) ? MessageResource::make($this->lastMessage)->resolve() : null,
            'unreadble_count' => $this->unreadable_message_statuses_count
        ];
    }
}
