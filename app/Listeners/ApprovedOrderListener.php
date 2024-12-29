<?php

namespace App\Listeners;

use App\Events\ApproveOrderEvent;
use App\Events\TheOrderApprovedSuccessfullyEvent;
use App\Jobs\JobApproveOrder;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ApprovedOrderListener
{
    public function handle(ApproveOrderEvent $event): void
    {
        $batch = Bus::batch([

            new JobApproveOrder($event->order),

            ])->then(function(Batch $batch) use ($event){

                TheOrderApprovedSuccessfullyEvent::dispatch($event->order);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                
            })

            ->finally(function(Batch $batch){


        })->name('order_approbation')->dispatch();
    }

    
}
