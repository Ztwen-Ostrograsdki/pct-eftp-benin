<?php

namespace App\Listeners;

use App\Events\EpreuveHasBeenCreatedSuccessfullyEvent;
use App\Events\EpreuveWasCreatedSuccessfullyEvent;
use App\Events\InitEpreuveCreationEvent;
use App\Jobs\JobCreateNewEpreuve;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class CreateNewEpreuveListener
{
    public function handle(InitEpreuveCreationEvent $event): void
    {
        $batch = Bus::batch([

            new JobCreateNewEpreuve($event->data, $event->file_epreuve),

            ])->then(function(Batch $batch) use ($event){

                EpreuveHasBeenCreatedSuccessfullyEvent::dispatch();

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('new_epreuve_created')->dispatch();
    }

}
