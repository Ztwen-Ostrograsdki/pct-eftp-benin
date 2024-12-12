<?php

namespace App\Listeners;

use App\Events\InitiateNewOrderEvent;
use App\Events\NewOrderHasBeenCreatedSuccessfullyEvent;
use App\Events\OrderCreationHasBeenFailedEvent;
use App\Jobs\JobOrderManager;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class BuildNewOrderListener
{
    
    /**
     * Handle the event.
     */
    public function handle(InitiateNewOrderEvent $event): void
    {
        $batch = Bus::batch([

            new JobOrderManager($event->user, $event->data),

            ])->then(function(Batch $batch) use ($event){

                NewOrderHasBeenCreatedSuccessfullyEvent::dispatch($event->user, $event->data['order_identifiant']);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                OrderCreationHasBeenFailedEvent::dispatch($event->user);
            })

            ->finally(function(Batch $batch){


        })->name('new_order')->dispatch();
    }
}
