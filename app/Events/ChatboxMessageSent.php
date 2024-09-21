<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Models\Chatbox;
use App\Models\ChatboxMessage;

class ChatboxMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatboxMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatboxMessage $message)
    {
        $this->message = $message;
        $this->chatbox = $message->chatbox;
        $this->user = $this->chatbox->user;
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message, 
        ];
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('1 - Broadcast channel, owner : ' . $this->user->id);
        return [
            new PrivateChannel('chatbox'),
            new PrivateChannel('chatbox.'. $this->user->id)
        ];
    }


    
    
}
