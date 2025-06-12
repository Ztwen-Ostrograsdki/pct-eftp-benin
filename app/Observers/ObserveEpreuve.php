<?php

namespace App\Observers;

use App\Events\NewEpreuveHasBeenPublishedEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
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
        ModelsRobots::notificationToAdminsThatNewEpreuveHasBeenPublished($epreuve->user, $epreuve);

        $admins = ModelsRobots::getUserAdmins();

        $user = $epreuve->user;

        $since = __formatDateTime($epreuve->created_at);

        $message = "Validation d'une épreuve publiée par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". L'épreuve a été publiée le " . $since . " .";

        Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

    }

    /**
     * Handle the Epreuve "updated" event.
     */
    public function updated(Epreuve $epreuve): void
    {
        //
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
