<?php

namespace App\Console\Commands;

use App\Jobs\JobResetUserAccount;
use Illuminate\Console\Command;

class ResetUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restorer:compte {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Restoration de compte utilisateur";

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

                $dispatched = JobResetUserAccount::dispatch($admin, $user);

                if($dispatched){

                    $this->alert("La réinitialisation du compte de l'utilisateur {$user->getFullName()} a été lancé");

                    $this->info("Processus lancé...");

                }
            }
            else{
                $this->error("ALERTE : Aucun utilisateur n'a été trouvé avec l'adresse mail {$email} dans la base de données");
            }


        }
    }
}
