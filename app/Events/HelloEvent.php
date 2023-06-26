<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HelloEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $message;
    private int $senderId;
    private int $receiverId;
    /**
     * Create a new event instance.
     */
    public function __construct(int $senderId, int $receiverId, string $message)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('public.chat.1');
        
    }

    public function broadcastAs()
    {
        return 'chat-msg';
    }

    public function broadcastWith()
    {
        return [
            'sender_id' => $this->senderId,
            'reicever_id' => $this->receiverId,
            'message' => $this->message
        ];
    }
}
