<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiveMessage implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels, Dispatchable;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // info('receive-message-' . "-" . $this->data['receiver'] . '-' . $this->data['sender']);
        return [
            new PrivateChannel('receive-message-' . $this->data['receiver'] . '-' . $this->data['sender']),

            new PrivateChannel('user-' . $this->data['receiver']),
        ];
    }

    public function broadcastAs()
    {
        return 'receive-message';
    }

    public function broadcastWith(): array
    {
        return $this->data;
    }

}
