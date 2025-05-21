<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NotifyUserThatAccountHasBeenConfirmedByAdmins;
use App\Notifications\SendDynamicMailToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobToSendEmailToIdentifiedUser implements ShouldQueue
{
    use Queueable;

     /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin,
        public User $user,
    )
    {
        $this->admin = $admin;

        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = $this->admin;

        $user = $this->user;

        $subjet = "Confirmation de l'identification utilisateur de la plateforme" . config('app.name') . " du compte " . $user->email;

        $body = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous avez confirmé l'identification de l'utilisateur " 
            . $user->getFullName(true) . 
            " dont l'addresse mail est "
            . $user->email . 
            " et dont l'identifiant unique utilisateur est "
            . $user->identifiant .
            "La confirmation s'est déroulée avec success et l'utilisateur pourra se connecter à son compte."
        ;

        $this->user->notify(new NotifyUserThatAccountHasBeenConfirmedByAdmins(true));

        $admin->notify(new SendDynamicMailToUser($subjet, $body));


        
    }
}
