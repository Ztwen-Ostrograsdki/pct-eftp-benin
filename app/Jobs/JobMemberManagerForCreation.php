<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobMemberManagerForCreation implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin,
        public User $user,
        public array $data,
        public ?Member $member = null,

    )
    {
        $this->user = $user;

        $this->admin = $admin;

        $this->data = $data;

        $this->member = $member;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->member->update($this->data);
    }
}
