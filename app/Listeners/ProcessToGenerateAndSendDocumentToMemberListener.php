<?php

namespace App\Listeners;

use App\Events\InitProcessToGenerateAndSendDocumentToMemberEvent;
use App\Jobs\JobGeneratePrintingPDFFromView;
use App\Jobs\JobToSendCommuniqueToMembers;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ProcessToGenerateAndSendDocumentToMemberListener
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToGenerateAndSendDocumentToMemberEvent $event): void
    {
        $jobs = [];

        foreach($event->users as $user){

            $jobs[] = new JobGeneratePrintingPDFFromView($event->view_path, $event->data[$user->id]['data'], $event->data[$user->id]['document_path'], $user, true, $event->admin_generator);

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

                $progress = $batch->progress();

                $message_to_creator = $progress . " % mails envoyés!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "L'envoie des documents aux membres en masse par mail s'est achevée avec succès!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "L'envoie des documents aux membres en masse par mail a échoué!";                

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('build_end_send_documents_to_members_by_mail')->dispatch();
    }
}
