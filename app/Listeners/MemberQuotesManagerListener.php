<?php

namespace App\Listeners;

use App\Events\MemberQuotesUpdatedEvent;
use App\Events\UpdateMemberQuotesEvent;
use App\Jobs\JobMemberQuotesManager;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class MemberQuotesManagerListener
{
    /**
     * Handle the event.
     */
    public function handle(UpdateMemberQuotesEvent $event): void
    {
        $batch = Bus::batch([

            new JobMemberQuotesManager($event->user, $event->content, $event->quote)
            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->user], new RealTimeNotificationGetToUser("La citation a bien été enregistrée et publiée!"));
                
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->user], new RealTimeNotificationGetToUser("L'insertion de la citation a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('member_quote_manager')->dispatch();
    }
}
