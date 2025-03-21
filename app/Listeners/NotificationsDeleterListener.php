<?php

namespace App\Listeners;

use App\Events\NotificationsDeletedSuccessfullyEvent;
use App\Events\NotificationsDeletingEvent;
use App\Jobs\JobNotificationsDeleter;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class NotificationsDeleterListener
{
    /**
     * Handle the event.
     */
    public function handle(NotificationsDeletingEvent $event): void
    {
        $batch = Bus::batch([

            new JobNotificationsDeleter($event->user, $event->data),

        ])->then(function(Batch $batch) use ($event){

            NotificationsDeletedSuccessfullyEvent::dispatch($event->user);
        })
        ->catch(function(Batch $batch, Throwable $er){

            
        })

        ->finally(function(Batch $batch){


    })->name('notifications_deleting')->dispatch();
    }
}
