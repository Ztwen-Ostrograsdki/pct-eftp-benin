<?php

namespace App\Jobs;

use App\Models\Lycee;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobInsertNewLyceeData implements ShouldQueue
{
    use Queueable, Batchable;

    public $data = [];

    public $editing_lycee_id = null;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $editing_lycee_id = null)
    {
        $this->data = $data;

        $this->editing_lycee_id = $editing_lycee_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(!$this->editing_lycee_id){

            Lycee::create($this->data);

        }
        elseif($this->editing_lycee_id){

            $editing_lycee = Lycee::find($this->editing_lycee_id);

            $editing_lycee->update($this->data);

        }
    }
}
