<?php

namespace App\Observers;

use App\Helpers\Tools\ModelsRobots;
use App\Models\SupportFile;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\Notification;

class ObserveSupportFile
{
    /**
     * Handle the SupportFile "created" event.
     */
    public function created(SupportFile $supportFile): void
    {
        $user = $supportFile->user;

        if($user->isAdminsOrMaster() || $user->hasRole('epreuves-manager')){

            $supportFile->update(['authorized' => true, 'hidden' => false]);

            $admins = ModelsRobots::getUserAdmins(null, $user->id);

            if(count($admins)){

                $since = __formatDateTime($supportFile->created_at);

                $message = "Nouveau support de cours publié par l'administrateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Support de cours publié le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
            }

        }
        else{

            ModelsRobots::notificationToAdminsThatSupportFileHasBeenPublished($supportFile->user, $supportFile);

            $admins = ModelsRobots::getUserAdmins();

            if(count($admins)){

                $since = __formatDateTime($supportFile->created_at);

                $message = "Validation d'un support de cours publié par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Support de cours publié le " . $since . " .";

                Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

            }
        }

        $msg = "Votre fichier a été publié avec succès!";

        Notification::sendNow([$user], new RealTimeNotificationGetToUser($msg));
    }

    /**
     * Handle the SupportFile "updated" event.
     */
    public function updated(SupportFile $supportFile): void
    {
        //
    }

    /**
     * Handle the SupportFile "deleted" event.
     */
    public function deleted(SupportFile $supportFile): void
    {
        //
    }

    /**
     * Handle the SupportFile "restored" event.
     */
    public function restored(SupportFile $supportFile): void
    {
        //
    }

    /**
     * Handle the SupportFile "force deleted" event.
     */
    public function forceDeleted(SupportFile $supportFile): void
    {
        //
    }
}
