<?php

namespace App\Jobs;

use App\Helpers\Services\JobResportsService;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobToDeleteUserAccount implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin_generator,
        public User $user_to_delete,
    )
    {
        $this->user_to_delete = $user_to_delete;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // SUPPRESSION DU COMPTE ICI









        
        $batchId = null;

        if($this->batch()) $batchId = $this->batch()->id;

        $user_name = $this->user_to_delete->getFullName(true) . "(" . $this->user_to_delete->email . ")";

        $data = [
            'batch_id' => $batchId,
            'job_id' => $this->job?->uuid(),
            'job_class' => static::class,
            'status' => 'ok',
            'report' => "Le compte de {$user_name} a été supprimé",
            'payload' => $this->job?->payload(),
        ];

        JobResportsService::generatejobReport($data);
    }
}
