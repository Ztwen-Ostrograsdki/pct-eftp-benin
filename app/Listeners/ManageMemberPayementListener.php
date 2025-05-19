<?php

namespace App\Listeners;

use App\Events\InitNewMemberPaymentEvent;
use App\Events\MemberPaymentRequestCompletedEvent;
use App\Events\MemberPaymentRequestFailEvent;
use App\Jobs\JobManageMemberPayement;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ManageMemberPayementListener
{
    

    /**
     * Handle the event.
     */
    public function handle(InitNewMemberPaymentEvent $event): void
    {
        $batch = Bus::batch([

            new JobManageMemberPayement($event->admin, $event->data, $event->member, $event->cotisation)
            ])->then(function(Batch $batch) use ($event){

                $name = $event->member->user->getFullName();

                Notification::sendNow([$event->admin], new RealTimeNotificationGetToUser("La procédure d'enregistrement du payement de " . $name . " s'est achevée avec succès!"));

                MemberPaymentRequestCompletedEvent::dispatch($event->admin, $event->data);
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                MemberPaymentRequestFailEvent::dispatch($event->admin, $event->data);

                $name = $event->member->user->getFullName();

                Notification::sendNow([$event->admin], new RealTimeNotificationGetToUser("La procédure d'enregistrement du payement de " . $name . " a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('member_payment_creation')->dispatch();
    }
}
