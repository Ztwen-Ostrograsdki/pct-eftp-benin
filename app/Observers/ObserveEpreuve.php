<?php

namespace App\Observers;

use App\Events\NewEpreuveHasBeenPublishedEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\Epreuve;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\Notification;

class ObserveEpreuve
{
    /**
     * Handle the Epreuve "created" event.
     */
    public function created(Epreuve $epreuve): void
    {
        $user = $epreuve->user;

        if($user->isAdminsOrMaster() || $user->hasRole('epreuves-manager')){

            $epreuve->update(['authorized' => true, 'hidden' => false]);

            $admins = ModelsRobots::getUserAdmins(null, $user->id);

            if(count($admins)){

                $since = __formatDateTime($epreuve->created_at);

                $message = "Nouvelle épreuve publiée par l'administrateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Epreuve publiée le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
            }

        }
        else{

            ModelsRobots::notificationToAdminsThatNewEpreuveHasBeenPublished($epreuve->user, $epreuve);

            $admins = ModelsRobots::getUserAdmins();

            if(count($admins)){
                
                $since = __formatDateTime($epreuve->created_at);

                $message = "Validation d'une épreuve publiée par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Epreuve publiée le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
            }


        }

        $msg = "Votre épreuve a été publiée avec succès!";

        Notification::sendNow([$user], new RealTimeNotificationGetToUser($msg));
    }

    /**
     * Handle the Epreuve "updated" event.
     */
    public function updated(Epreuve $epreuve): void
    {
        NewEpreuveHasBeenPublishedEvent::dispatch($epreuve->user);
    }

    /**
     * Handle the Epreuve "deleted" event.
     */
    public function deleted(Epreuve $epreuve): void
    {
        //
    }

    /**
     * Handle the Epreuve "restored" event.
     */
    public function restored(Epreuve $epreuve): void
    {
        //
    }

    /**
     * Handle the Epreuve "force deleted" event.
     */
    public function forceDeleted(Epreuve $epreuve): void
    {
        //
    }
}
