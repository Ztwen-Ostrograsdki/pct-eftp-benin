<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobToUnblockUserAccount implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public int $waiting_for = 0
    )
    {
        $this->user = $user;

        $this->delay = $waiting_for;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        if($user && !$user->isMaster()){

            $user->userBlockerOrUnblockerRobot(false);
        }
    }
}
