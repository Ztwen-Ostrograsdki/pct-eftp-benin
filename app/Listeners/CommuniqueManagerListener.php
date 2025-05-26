<?php

namespace App\Listeners;

use App\Events\InitCommuniqueManagerEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Jobs\JobToManageCommunique;
use App\Models\Communique;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class CommuniqueManagerListener
{

    /**
     * Handle the event.
     */
    public function handle(InitCommuniqueManagerEvent $event): void
    {
        $batch = Bus::batch([

            new JobToManageCommunique($event->admin_generator, $event->data, $event->communique)
            ])->then(function(Batch $batch) use ($event){

                $admins = ModelsRobots::getAllAdmins();

                Notification::sendNow($admins, new RealTimeNotificationGetToUser("Le processus est terminé: Le document du communiqué est prêt!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser("La génération du document a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('communique_document_generator')->dispatch();
    }
}
