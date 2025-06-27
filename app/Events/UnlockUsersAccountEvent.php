<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnlockUsersAccountEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ?array $users_targets_ids = [],
        public User $admin_generator,
        public bool $just_unblock_all_users_acounts = false,
        public ?int $delay = 0
    )
    {
        $this->users_targets_ids = $users_targets_ids;

        $this->admin_generator = $admin_generator;

        $this->just_unblock_all_users_acounts = $just_unblock_all_users_acounts;

        $this->delay = $delay;
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
