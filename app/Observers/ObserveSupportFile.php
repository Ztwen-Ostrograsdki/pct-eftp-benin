<?php

namespace App\Observers;

use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
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
        ModelsRobots::notificationToAdminsThatSupportFileHasBeenPublished($supportFile->user, $supportFile);

        $admins = ModelsRobots::getUserAdmins();

        $user = $supportFile->user;

        $since = __formatDateTime($supportFile->created_at);

        $message = "Validation d'un support de cours publié par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Le support de cours a été publié le " . $since . " .";

        Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
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
