<?php

namespace App\Jobs;

use App\Models\Epreuve;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class JobCreateNewEpreuve implements ShouldQueue
{
    use Queueable, Batchable;

    public $data = [];

    public $file_epreuve;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, $file_epreuve)
    {
        $this->data = $data;

        $this->file_epreuve = $file_epreuve;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;

        $path = $data['path'];


        if($path){

            $epreuve = Epreuve::create($data);

            if(!$epreuve){

                Storage::delete($path);

            }
        }
        

        
    }
}
