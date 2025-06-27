<?php

namespace App\Listeners;

use App\Events\BlockUserEvent;
use App\Events\LogoutUserEvent;
use App\Events\UserHasBeenBlockedSuccessfullyEvent;
use App\Jobs\JobBlockUser;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class BlockUserListener
{
    

    /**
     * Handle the event.
     */
    public function handle(BlockUserEvent $event): void
    {
        $jobs = [];

        $users = [];

        $users_targets_ids = $event->users_targets_ids;

        if($event->user && empty($users_targets_ids)){

            $jobs[] = new JobBlockUser($event->user);

        }
        if(!empty($users_targets_ids)){

            $users = User::whereIn('id', $users_targets_ids)->get();

            if(count($users) > 0){

                foreach($users as $user){

                    $jobs[] = new JobBlockUser($user, true);

                }

            }
        }
        elseif($event->just_block_all_users){

            $users = User::where('blocked', false)->get();
    
            if(count($users) > 0){

                foreach($users as $user){

                    if($user && !$user->isMaster()){

                        $jobs[] = new JobBlockUser($user, true);
                    }

                }

            }
        }


        $batch = Bus::batch($jobs)
            ->then(function(Batch $batch) use ($event, $users_targets_ids, $users){

                if($event->user && empty($users_targets_ids)){

                    UserHasBeenBlockedSuccessfullyEvent::dispatch($event->user);

                    $message = "Le compte de l'utilisateur " . $event->user->getFullName() . " a été bloqué avec succès!";
                    
                    Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: " . $message));

                    LogoutUserEvent::dispatch($event->user);
                }
                if(count($users)){

                    foreach($users as $u){

                        UserHasBeenBlockedSuccessfullyEvent::dispatch($u);

                        $message = "Le compte de l'utilisateur " . $u->getFullName() . " a été bloqué avec succès!";
                        
                        Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: " . $message));

                        LogoutUserEvent::dispatch($u);
                        
                    }

                }
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message = "Le processus de blocage de compte lancé à échoué!";
                        
                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message));
                
            })

            ->finally(function(Batch $batch){


        })->name('users_blocking')->dispatch();
    }
}
