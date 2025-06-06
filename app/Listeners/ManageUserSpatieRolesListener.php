<?php

namespace App\Listeners;

use App\Events\InitProcessToManageUserSpatieRolesEvent;
use App\Events\RoleUsersWasUpdatedEvent;
use App\Jobs\JobToManageUserSpatiesRoles;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ManageUserSpatieRolesListener
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToManageUserSpatieRolesEvent $event): void
    {
        $batch = Bus::batch([

                new JobToManageUserSpatiesRoles($event->user, $event->selected_roles, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                $user_name = $event->user->getFullName();

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La mise à jour de la liste des rôles administrateurs de {$user_name} s'est déroulée avec succès!"));

                RoleUsersWasUpdatedEvent::dispatch();
            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                $user_name = $event->user->getFullName();

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La mise à jour de la liste des rôles administrateurs de {$user_name} a échoué! Veuillez renseigner"));
                
            })

            ->finally(function(Batch $batch){


        })->name('user_roles_managing')->dispatch();
    }
}
