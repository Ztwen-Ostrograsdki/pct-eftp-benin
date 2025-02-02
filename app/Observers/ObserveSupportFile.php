<?php

namespace App\Observers;

use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\SupportFile;

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

        $since = $supportFile->__getDateAsString($supportFile->created_at, 3, true);

        $object = "Validation d'une fiche de cours publiée sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
        " et d'identifiant personnel : ID = " . $user->identifiant;

        $content = "Vous recevez cette notification parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer le support publiée par "
        . $user->getUserNamePrefix() . " " . $user->getFullName(true) . ". Le support a été publié le " . $since . " ." ;
        
        $title = "Validation d'une fiche de cours publié";
        
        $data = [
            'user_id' => $user->id,
            'content' => $content,
            'title' => $title,
            'object' => $object,
            'receivers' => $admins,

        ];

        ENotification::create($data);
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
