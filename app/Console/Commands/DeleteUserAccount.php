<?php

namespace App\Console\Commands;

use App\Events\InitUserAccountDeletionEvent;
use Illuminate\Console\Command;

class DeleteUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supprimer:compte {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suppression de compte utilisateur à partir du email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if($email){

            $user = getUser($email, 'email');

            $admin = findUser(1);

            if($user){

                $dispatched = InitUserAccountDeletionEvent::dispatch($admin, [$user->id]);

                if($dispatched){

                    $this->alert("La suppresion du compte de l'utilisateur {$user->getFullName()} a été lancé");

                    $this->info("Processus lancé...");

                }
            }
            else{
                $this->error("ALERTE : Aucun utilisateur n'a été trouvé avec l'adresse mail {$email} dans la base de données");
            }


        }
    }
}
