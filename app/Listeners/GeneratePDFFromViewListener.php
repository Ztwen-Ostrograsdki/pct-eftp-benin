<?php

namespace App\Listeners;

use App\Events\InitPDFGeneratorEvent;
use App\Jobs\JobGeneratePrintingPDFFromView;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class GeneratePDFFromViewListener
{

    /**
     * Handle the event.
     */
    public function handle(InitPDFGeneratorEvent $event): void
    {
        $batch = Bus::batch([

            new JobGeneratePrintingPDFFromView($event->view_path, $event->data, $event->path, $event->user, $event->send_by_mail, $event->admin_generator)
            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("Le processus est terminé: Votre document est prêt!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La génération du document a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('member_document_generator')->dispatch();
    }
}
