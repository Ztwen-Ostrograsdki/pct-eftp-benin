<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobNotificationsDeleter implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    public $data;

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
        $data = $this->data;

        DB::transaction(function () use ($data){

            foreach($data as $notif){

                $notif->delete();

            }
            
        });
    }
}
