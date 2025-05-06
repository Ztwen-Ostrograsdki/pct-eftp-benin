<?php

namespace App\Jobs;

use App\Helpers\Tools\ModelsRobots;
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

            $is_exam = $data['is_exam'];

            if($is_exam){

                $exam_type = $data['exam_type'];

                $promotion_id = getExamPromotions($exam_type, true);

                $data['promotion_id'] = $promotion_id;

            }

            $epreuve = Epreuve::create($data);

            if(!$epreuve){

                ModelsRobots::deleteFileFromStorageManager($path);

            }

        }
    }
}
