<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnlineStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $isOnline;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $isOnline)
    {
        $this->userId   = $userId;
        $this->isOnline = $isOnline;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user-online-status.' . $this->userId),
        ];
    }

    public function broadcastAs()
    {
        return 'user.message.online.status.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'user_id'   => $this->userId,
            'is_online' => $this->isOnline,
        ];
    }
}
