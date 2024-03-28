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
            'title' => $this->title,
            'users' => $this->users,
            'last_message' => MessageResource::make($this->lastMessage)->resolve(),
            'unreadble_count' => $this->unreadable_message_statuses_count
        ];
    }
}
