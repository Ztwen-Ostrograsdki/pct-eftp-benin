<?php

namespace App\Listeners;

use App\Events\BlockUserEvent;
use App\Events\LogoutUserEvent;
use App\Events\UserHasBeenBlockedSuccessfullyEvent;
use App\Jobs\JobBlockUser;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class BlockUserListener
{
    

    /**
     * Handle the event.
     */
    public function handle(BlockUserEvent $event): void
    {
        $batch = Bus::batch([

            new JobBlockUser($event->user),

            ])->then(function(Batch $batch) use ($event){

                UserHasBeenBlockedSuccessfullyEvent::dispatch($event->user);

                $message = "L'utilisateur " . $event->user->getFullName() . " a été bloqué avec succès!";
                
                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: " . $message));

                LogoutUserEvent::dispatch($event->user);

            })
            ->catch(function(Batch $batch, Throwable $er){

                
            })

            ->finally(function(Batch $batch){


        })->name('user_blocking')->dispatch();
    }
}
