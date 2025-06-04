<?php

namespace App\Listeners;

use App\Events\InitProcessToDeleteSpatieRolesEvent;
use App\Events\RolePermissionsWasUpdatedEvent;
use App\Events\RoleUsersWasUpdatedEvent;
use App\Jobs\JobDeletSpatieRoles;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SpatieRolesDestroyerListener
{
    /**
     * Handle the event.
     */
    public function handle(InitProcessToDeleteSpatieRolesEvent $event): void
    {
        $batch = Bus::batch([

                new JobDeletSpatieRoles($event->roles_id, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La suppression des rôles administrateurs s'est déroulée avec succès!"));

                RoleUsersWasUpdatedEvent::dispatch();

                RolePermissionsWasUpdatedEvent::dispatch();
            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La suppression des rôles administrateurs a échoué! Veuillez renseigner"));

                
            })

            ->finally(function(Batch $batch){


        })->name('roles_destroyer')->dispatch();
    }
}
