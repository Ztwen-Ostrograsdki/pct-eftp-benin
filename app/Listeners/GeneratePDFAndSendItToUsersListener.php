<?php

namespace App\Listeners;

use App\Events\InitProcessToGeneratePDFAndSendItToUsersEvent;
use App\Jobs\JobGeneratePrintingPDFFromView;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class GeneratePDFAndSendItToUsersListener
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToGeneratePDFAndSendItToUsersEvent $event): void
    {
        $receivers = $event->users;

        $jobs = [];

        if($receivers){

            foreach($receivers as $user){

                $jobs[] = new JobGeneratePrintingPDFFromView($event->view_path, $event->data, $event->path, $user, $event->send_by_mail, $event->admin_generator);
            }
        }


        $batch = Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

                $progress = $batch->progress();

                $message_to_creator = $progress . " % des mails envoyés!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: Votre document est prêt et a été envoyé aux destinataires!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La génération et l'envoi du document a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('members_document_generator')->dispatch();
    }
}
