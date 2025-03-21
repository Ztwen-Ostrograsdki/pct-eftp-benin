<?php

namespace App\Listeners;

use App\Events\InitLawChaptersCreationEvent;
use App\Events\LawChaptersCreationCompletedEvent;
use App\Jobs\JobCreateLawChapters;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class LawChaptersCreationListener
{
    

    /**
     * Handle the event.
     */
    public function handle(InitLawChaptersCreationEvent $event): void
    {
        $batch = Bus::batch([

            new JobCreateLawChapters($event->law, $event->data, $event->user),

            ])->then(function(Batch $batch) use ($event){

                LawChaptersCreationCompletedEvent::dispatch($event->law, $event->data, $event->user);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('law_chapter_creation')->dispatch();
    }
}
