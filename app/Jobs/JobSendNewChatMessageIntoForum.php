<?php

namespace App\Jobs;

use App\Models\ForumChat;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobSendNewChatMessageIntoForum implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    public $data = [];

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $data)
    {
        $this->data = $data;

        $this->user = $user;
    }

    
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ForumChat::create($this->data);
    }
}
