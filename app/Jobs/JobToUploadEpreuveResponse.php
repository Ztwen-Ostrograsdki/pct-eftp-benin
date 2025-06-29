<?php

namespace App\Jobs;

use App\Helpers\Tools\ModelsRobots;
use App\Models\EpreuveResponse;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobToUploadEpreuveResponse implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $data,
        public $file_path
    )
    {
        $this->data = $data;

        $this->file_path = $file_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->file_path;

        $data = $this->data;

        if($path){

            $created = EpreuveResponse::create($data);

            if(!$created){

                ModelsRobots::deleteFileFromStorageManager($path);

            }

        }
           
    }
}
