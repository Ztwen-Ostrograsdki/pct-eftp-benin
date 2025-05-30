<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetUserDataCommand extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restorer:donnee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Restoration des données utilisateur";

    /**

     * Execute the console command.
     */
    public function handle()
    {
        $users = getUsers();

        
        $this->info("Processus lancé...");

        foreach($users as $user){

            $this->alert("La réinitialisation de l'identifiant de l'utilisateur {$user->getFullName()} est en cours...");

            $done = $user->resetIdentifiant();

            if($done) $this->info("La réinitialisation de l'identifiant de l'utilisateur {$user->getFullName()} est terminée!");


        }
    }
}
