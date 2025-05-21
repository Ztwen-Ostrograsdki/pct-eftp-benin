<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobToGenerateDefaultUserMember implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        if($user->emailVerified() && $user->confirmed_by_admin){

            if(!$user->member){

                $data = [
                    'user_id' => $user->id,
                    'role_id' => null,
                ];

                Member::create($data);
            }

        }
    }
}
