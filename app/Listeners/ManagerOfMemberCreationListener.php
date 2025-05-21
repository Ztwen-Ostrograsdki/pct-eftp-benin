<?php

namespace App\Listeners;

use App\Events\MemberCreationOrUpdatingManagerEvent;
use App\Jobs\JobMemberManagerForCreation;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ManagerOfMemberCreationListener
{
    /**
     * Handle the event.
     */
    public function handle(MemberCreationOrUpdatingManagerEvent $event): void
    {
        $batch = Bus::batch([

            new JobMemberManagerForCreation($event->admin, $event->user, $event->data, $event->member)
            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin], new RealTimeNotificationGetToUser("Le processus de modification du poste de {$event->user->getFullName()} s'est bien déroulé !"));
                
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->admin], new RealTimeNotificationGetToUser("Le processus de modification du poste de {$event->user->getFullName()} a échoué !"));

            })

            ->finally(function(Batch $batch){


        })->name('member_creation_manager')->dispatch();
    }
}
