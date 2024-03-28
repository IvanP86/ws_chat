<?php

namespace App\Events;

use App\Http\Resources\Message\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageStatusEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $count;
    private $chat_id;
    private $user_id;
    private $message;
    /**
     * Create a new event instance.
     */
    public function __construct($count, $chat_id, $user_id, $message)
    {
        $this->count = $count;
        $this->chat_id = $chat_id;
        $this->user_id = $user_id;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('users.'. $this->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store-message-status';
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chat_id,
            'count' => $this->count,
            'message' => MessageResource::make($this->message)->resolve()
        ];
    }    
}
