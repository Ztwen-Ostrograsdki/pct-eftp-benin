<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InitProcessToSendSimpleMailMessageToUsersEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public $receivers_details = [],
        public $receiver_mail = null,
        public $receiver_full_name = null,
        public $message = null,
        public $file_to_attach_path = null,
        public $lien = null
    )
    {
        $this->receivers_details = $receivers_details;

        $this->receiver_full_name = $receiver_full_name;

        $this->receiver_mail = $receiver_mail;

        $this->message = $message;

        $this->lien = $lien;

        $this->file_to_attach_path = $file_to_attach_path;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public'),
        ];
    }
}
