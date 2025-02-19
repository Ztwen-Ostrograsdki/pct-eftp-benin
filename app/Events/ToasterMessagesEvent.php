<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ToasterMessagesEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $toaster_name;

    public $toaster_message;

    public $toaster_type = 'success';

    public $toaster_icon = 'check';

    public $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct($toaster_name, $toaster_message, $toaster_type = 'success',  $toaster_icon = 'check', $user_id)
    {
        $this->toaster_name = $toaster_name;

        $this->toaster_message = $toaster_message;

        $this->toaster_type = $toaster_type;

        $this->toaster_icon = $toaster_icon;

        $this->user_id = $user_id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->user_id),
        ];
    }

    public function broadcastWith() : array
    {
        return [
            'toaster_data' => [
                'name' => $this->toaster_name,
                'message' => $this->toaster_message,
                'type' => $this->toaster_type,
                'icon' => $this->toaster_icon,
            ],
        ];
    }
}
