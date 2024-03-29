<?php

namespace App\Events;

use App\Http\Resources\Message\MessageToOthersResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Log::info('broadcastOn');
        // Log::info($this->message);
        return [
            new Channel('store-message.'. $this->message->chat_id)
        ];
        // return new Channel('store-message');
    }

    public function broadcastAs(): string
    {
        // Log::info('broadcastAs');
        // Log::info($this->message);
        return 'store-message';
    }

    public function broadcastWith(): array
    {
        // Log::info('broadcastWith');
        // Log::info($this->message);
        return [
            'message' => MessageToOthersResource::make($this->message)->resolve()
        ];
    }
}
