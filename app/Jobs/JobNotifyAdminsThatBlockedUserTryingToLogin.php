<?php

namespace App\Jobs;

use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobNotifyAdminsThatBlockedUserTryingToLogin implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        $since = $user->__getDateAsString($user->blocked_at, 3, true);

        $user = $this->user;

        $title = "Tentative de connexion.";

        $object = "Compte bloqué.";

        $content = "L'utilisateur " 
                   . $user->getFullName(true) . 
                   " a tenté de se connecter a son compte. Le compte de cet utilisateur dont l'adresse mail est " 
                   . $user->email . " a été bloqué depuis le " . $since ;

        $admins = ModelsRobots::getUserAdmins();
        
        $data = [
            'user_id' => $user->id,
            'content' => $content,
            'title' => $title,
            'object' => $object,
            'receivers' => $admins,

        ];

        ENotification::create($data);
    }
}
