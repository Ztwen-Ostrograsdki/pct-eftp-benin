<?php

namespace App\Listeners;

use App\Events\InitUserAccountDeletionEvent;
use App\Events\UserAccountWasDeletedSuccessfullyEvent;
use App\Jobs\JobToDeleteUserAccount;
use App\Models\JobReportAfterProcessed;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ProcessToDeleteUserAccountListener
{
    /**
     * Handle the event.
     */
    public function handle(InitUserAccountDeletionEvent $event): void
    {
        $jobs = [];

        $users = User::whereIn('users.id', $event->users_id)->get();

        
        foreach($users as $user){

            $jobs[] = new JobToDeleteUserAccount($event->admin_generator, $user);

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

                $progress = $batch->progress();

                $job_report = JobReportAfterProcessed::where('batch_id', $batch->id)->first();

                if($job_report){

                    $message = $job_report->report;

                    $message_to_creator = $progress . " % des comptes de la procédure lancée ont été supprimés!";

                    Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message));
                    
                }


            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "La suppression de comptes lancé s'est achevée avec succès!";

                UserAccountWasDeletedSuccessfullyEvent::dispatch($event->admin_generator, $message_to_creator);

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La suppression de compte de membres en masse a échoué";                

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('users_account_deletion_process')->dispatch();
    
    }
}
