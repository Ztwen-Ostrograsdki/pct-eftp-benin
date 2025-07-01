<?php

namespace App\Jobs;

use App\Helpers\Tools\ModelsRobots;
use App\Models\SupportFile;
use Illuminate\Bus\Batchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class JobCreateNewSupportFile implements ShouldQueue
{
    use Queueable, Batchable;

    public $data = [];

    public $support_file;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, $support_file)
    {
        $this->data = $data;

        $this->support_file = $support_file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;

        $path = $data['path'];


        if($path){

            $fiche = SupportFile::create($data);

            if(!$fiche){

                ModelsRobots::deleteFileFromStorageManager($path);


            }
        }
        

        
    }
}
