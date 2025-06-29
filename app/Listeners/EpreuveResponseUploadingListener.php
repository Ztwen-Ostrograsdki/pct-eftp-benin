<?php

namespace App\Listeners;

use App\Events\InitEpreuveResponseUploadingEvent;
use App\Events\NewEpreuveResponseHasBeenPublishedEvent;
use App\Jobs\JobToUploadEpreuveResponse;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class EpreuveResponseUploadingListener
{
    /**
     * Handle the event.
     */
    public function handle(InitEpreuveResponseUploadingEvent $event): void
    {
        $batch = Bus::batch([

            new JobToUploadEpreuveResponse($event->data, $event->file_path),

            ])->then(function(Batch $batch) use ($event){

                NewEpreuveResponseHasBeenPublishedEvent::dispatch();

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $user = findUser($event->data['user_id']);

                $msg = "Une erreure est survenue lors de la publication de votre épreuve, Veuillez reessayer!";

                Notification::sendNow([$user], new RealTimeNotificationGetToUser($msg));

            })

            ->finally(function(Batch $batch){


        })->name('new_epreuve_response_created')->dispatch();
    }
}
