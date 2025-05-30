<?php

namespace App\Events;

use App\Models\Communique;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InitCommuniqueManagerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public User $admin_generator,
        public array $data,
        public $communique_key,
        public ?Communique $communique = null,

    )
    {
        $this->admin_generator = $admin_generator;

        $this->data = $data;

        $this->communique_key = $communique_key;

        $this->communique = $communique;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [

            new PrivateChannel('App.Models.User.' . $this->admin_generator->id),

        ];
    }
}
