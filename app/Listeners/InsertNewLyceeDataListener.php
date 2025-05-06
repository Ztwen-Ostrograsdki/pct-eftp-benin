<?php

namespace App\Listeners;

use App\Events\InitNewLyceeDataInsertionEvent;
use App\Events\NewLyceeCreatedSuccessfullyEvent;
use App\Jobs\JobInsertNewLyceeData;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class InsertNewLyceeDataListener
{
    

    /**
     * Handle the event.
     */
    public function handle(InitNewLyceeDataInsertionEvent $event): void
    {
        $batch = Bus::batch([

            new JobInsertNewLyceeData($event->data, $event->editing_lycee_id),

            ])->then(function(Batch $batch) use ($event){

                NewLyceeCreatedSuccessfullyEvent::dispatch($event->data);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('lycee_creation')->dispatch();
    }
}
