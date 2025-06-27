<?php

namespace App\Listeners;

use App\Events\InitProcessToSendSimpleMailMessageToUsersEvent;
use App\Events\UnlockUsersAccountEvent;
use App\Jobs\JobToUnblockUserAccount;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ProcessToUnlockUsersAccountListener
{

    /**
     * Handle the event.
     */
    public function handle(UnlockUsersAccountEvent $event): void
    {
        $jobs = [];

        $users = [];

        $users_targets_ids = $event->users_targets_ids;

       
        if(!empty($users_targets_ids)){

            $users = User::whereIn('id', $users_targets_ids)->get();

            if(count($users) > 0){

                foreach($users as $user){

                    $jobs[] = new JobToUnblockUserAccount($user, $event->delay);

                }

            }
        }
        elseif($event->just_unblock_all_users_acounts){

            $users = User::where('blocked', true)->get();
    
            if(count($users) > 0){

                foreach($users as $user){

                    if($user){

                        $jobs[] = new JobToUnblockUserAccount($user, $event->delay);
                    }

                }

            }
        }

        if(empty($jobs)){

            $message = "Le processus de déblocage des comptes a été avorté car aucun compte bloqué n'a été trouvé afin d'éxécuter son déblocage!";
                        
            Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message));

        }
        else{
            $batch = Bus::batch($jobs)
                ->then(function(Batch $batch) use ($event, $users){

                    if(count($users)){

                        $receivers_details = [];

                        $message = "Votre compte " . env('APP_NAME') . " est a nouveau actif";

                        $objet = "COMPTE REACTIVE";

                        foreach($users as $usr){

                            $receivers_details[] = [
                                'email' => $usr->email,
                                'full_name' => $usr->getFullName(),
                                'message' => $message,
                                'objet' => $objet,
                                'file_to_attach' => null,
                                'lien' => null

                            ];

                        }

                        if(!empty($receivers_details)){

                            InitProcessToSendSimpleMailMessageToUsersEvent::dispatch($receivers_details);
                        }

                        $message = "Les comptes ont été débloqués avec succès!";
                            
                        Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: " . $message));

                    }
                })
                ->catch(function(Batch $batch, Throwable $er) use ($event){

                    $message = "Le processus de déblocage de compte lancé à échoué!";
                            
                    Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message));
                    
                })

                ->finally(function(Batch $batch){

                    
                }

            )->name('users_unlocking')->dispatch();

        }
    }
}
