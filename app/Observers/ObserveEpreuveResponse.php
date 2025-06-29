<?php

namespace App\Observers;

use App\Events\NewEpreuveResponseHasBeenPublishedEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\EpreuveResponse;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\Notification;

class ObserveEpreuveResponse
{
    /**
     * Handle the EpreuveResponse "created" event.
     */
    public function created(EpreuveResponse $epreuveResponse): void
    {
        $user = $epreuveResponse->user;

        $epreuve = $epreuveResponse->epreuve;

        if($user->isAdminsOrMaster() || $user->hasRole('epreuves-manager')){

            $epreuveResponse->update(['authorized' => true]);

            $admins = ModelsRobots::getUserAdmins(null, $user->id);

            if(count($admins)){
                $since = __formatDateTime($epreuveResponse->created_at);

                $message = "Nouvel élément de réponses publié pour l'épreuve " . $epreuve->name . " par l'administrateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Epreuve publiée le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
            }

        }
        else{

            ModelsRobots::notificationToAdminsThatNewEpreuveResponseHasBeenPublished($epreuveResponse->user, $epreuveResponse);

            $admins = ModelsRobots::getUserAdmins();

            if(count($admins)){
                $since = __formatDateTime($epreuveResponse->created_at);

                $message = "Validation d'un élément de réponses pour l'épreuve " . $epreuve->name . " publiée par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Fichier publié le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

            }

        }

        $msg = "Votre élément de réponses a été publié avec succès!";

        Notification::sendNow([$user], new RealTimeNotificationGetToUser($msg));
    }

    /**
     * Handle the EpreuveResponse "updated" event.
     */
    public function updated(EpreuveResponse $epreuveResponse): void
    {
        NewEpreuveResponseHasBeenPublishedEvent::dispatch();
    }

    /**
     * Handle the EpreuveResponse "deleted" event.
     */
    public function deleted(EpreuveResponse $epreuveResponse): void
    {
        //
    }

    /**
     * Handle the EpreuveResponse "restored" event.
     */
    public function restored(EpreuveResponse $epreuveResponse): void
    {
        //
    }

    /**
     * Handle the EpreuveResponse "force deleted" event.
     */
    public function forceDeleted(EpreuveResponse $epreuveResponse): void
    {
        //
    }
}
