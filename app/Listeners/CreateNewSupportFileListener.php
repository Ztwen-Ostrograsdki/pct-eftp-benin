<?php

namespace App\Listeners;

use App\Events\InitSupportFileCreationEvent;
use App\Events\SupportFileWasCreatedSuccessfullyEvent;
use App\Jobs\JobCreateNewSupportFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class CreateNewSupportFileListener
{


    /**
     * Handle the event.
     */
    public function handle(InitSupportFileCreationEvent $event): void
    {
        $batch = Bus::batch([

            new JobCreateNewSupportFile($event->data, $event->support_file),

            ])->then(function(Batch $batch) use ($event){

                SupportFileWasCreatedSuccessfullyEvent::dispatch();

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('new_support_file_created')->dispatch();
    }
}
