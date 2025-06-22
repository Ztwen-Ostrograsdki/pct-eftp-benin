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

class InitPDFGeneratorEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public $view_path,
        public array $data,
        public $path,
        public ?User $user = null,
        public bool $send_by_mail = false,
        public ?User $admin_generator


    )
    {
        $this->user = $user;

        $this->admin_generator = $admin_generator;

        $this->send_by_mail = $send_by_mail;

        $this->path = $path;

        $this->view_path = $view_path;

        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        if($this->user){
            return [
                new PrivateChannel('App.Models.User.' . $this->user->id),
                new PrivateChannel('admin'),
            ];
        }

        return [
            new PrivateChannel('admin'),
        ];
    }
}
