<?php

namespace App\Jobs;

use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobNotifyAdminThatAUndentifiedUserTryingToLogin implements ShouldQueue
{
    use Queueable;

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

        $content = "L'utilisateur " . $user->getFullName(true) . " a tenté de se connecter a son compte. Le compte de cet utilisateur dont l'adresse mail est " . $user->email . " n'a pas encore été identifié!";

        $admins = ModelsRobots::getUserAdmins();
        
        $data = [
            'user_id' => $user->id,
            'content' => $content,
            'title' => "Tentative de connexion.",
            'object' => "Confirmation d'identification.",
            'receivers' => $admins,

        ];

        ENotification::create($data);
    }
}
