<?php

namespace App\Jobs;

use App\Models\Law;
use App\Models\LawChapter;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobCreateLawChapters implements ShouldQueue
{
    use Queueable, Batchable;

    public $law; 

    public $data = [];

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Law $law, array $data, User $user)
    {
        $this->law = $law;

        $this->data = $data;

        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {

            $data = $this->data;

            foreach($data as $datum){

                $create = LawChapter::create([
                    'chapter' => $datum['chapter'],
                    'slug' => $datum['slug'],
                    'description' => $datum['description'],
                    'law_id' => $this->law->id,
                ]);


            }
            
        });
    }
}
