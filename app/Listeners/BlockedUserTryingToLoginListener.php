<?php

namespace App\Listeners;

use App\Events\BlockedUserTryingToLoginEvent;
use App\Events\NotificationDispatchedToAdminsSuccessfullyEvent;
use App\Jobs\JobFlushUserBlockingRequestNotificationToAdmins;
use App\Jobs\JobNotifyAdminsThatBlockedUserTryingToLogin;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class BlockedUserTryingToLoginListener
{

    /**
     * Handle the event.
     */
    public function handle(BlockedUserTryingToLoginEvent $event): void
    {
        $batch = Bus::batch([

            new JobFlushUserBlockingRequestNotificationToAdmins($event->user),

            new JobNotifyAdminsThatBlockedUserTryingToLogin($event->user),

        ])->then(function(Batch $batch) use ($event){

            NotificationDispatchedToAdminsSuccessfullyEvent::dispatch($event->user);
        })
        ->catch(function(Batch $batch, Throwable $er){

            
        })

        ->finally(function(Batch $batch){


    })->name('blocked_user_try_to_connect')->dispatch();
    }
}
