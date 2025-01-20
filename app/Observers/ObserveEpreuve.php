<?php

namespace App\Observers;

use App\Events\NewEpreuveHasBeenPublishedEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\Epreuve;

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

        $since = $epreuve->__getDateAsString($epreuve->created_at, 3, true);

            $object = "Validation d'une épreuve publiée sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
            " et d'identifiant personnel : ID = " . $user->identifiant;

            $content = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer l'épreuve publiée par "
            . $user->getUserNamePrefix() . " " . $user->getFullName(true) . 
                
                ". L'épreuve a été publiée le " . $since . " ."
            ;
            $title = "Validation d'une épreuve publié";
        
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
