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

class InitProcessToGenerateAndSendDocumentToMemberEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $view_path,
        // public array $data,
        // public $path,
        // public ?User $user = null,
        // public bool $send_by_mail = false,
        // public ?User $admin_generator = null

    /**
     * Create a new event instance.
     */
    public function __construct(
        public $view_path,
        public array $data,
        public ?array $users = [],
        public bool $send_by_mail = false,
        public ?User $admin_generator = null


    )
    {
        $this->users = $users;

        $this->view_path = $view_path;

        $this->data = $data;

        $this->send_by_mail = $send_by_mail;

        $this->admin_generator = $admin_generator;
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
