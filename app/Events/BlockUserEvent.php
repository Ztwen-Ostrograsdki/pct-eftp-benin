<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlockUserEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user = null;

    public $admin_generator;

    public $users_targets_ids = [];

    public $just_block_all_users = false;

    /**
     * Create a new event instance.
     */
    public function __construct(?User $user = null, User $admin_generator, ?array $users = [], bool $just_block_all_users = false)
    {
        $this->user = $user;

        $this->admin_generator = $admin_generator;

        $this->users_targets_ids = $users;

        $this->just_block_all_users = $just_block_all_users;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin'),
        ];
    }
}
