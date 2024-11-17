<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionStart implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uniqueId;

    /**
     * Create a new event instance.
     */
    public function __construct($uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('session.' . $this->uniqueId),
        ];
    }

    public function broadcastAs()
    {
        return 'session-start';
    }
}
