<?php

namespace App\Jobs;

use App\Models\ForumChatSubject;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobDispatchForumChatSubject implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    public $data = [];

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;

        $this->data = $data;
    }

   
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ForumChatSubject::create($this->data);
    }
}
