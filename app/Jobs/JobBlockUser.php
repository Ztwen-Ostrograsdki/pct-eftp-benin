<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobBlockUser implements ShouldQueue
{
    use Queueable, Batchable;

    public $user, $block_this_user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $block_this_user = true)
    {
        $this->user = $user;

        $this->block_this_user = $block_this_user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        if($user && !$user->isMaster()){

            $user->userBlockerOrUnblockerRobot($this->block_this_user);
        }
    }
}
