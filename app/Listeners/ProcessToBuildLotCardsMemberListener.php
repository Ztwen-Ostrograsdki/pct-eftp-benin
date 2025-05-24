<?php

namespace App\Listeners;

use App\Events\InitProcessToBuildLotCardsMemberEvent;
use App\Events\MembersCardsCreationCompletedSucessfullyEvent;
use App\Events\MembersCardsCreationFailedEvent;
use App\Jobs\JobBuildCardMember;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ProcessToBuildLotCardsMemberListener
{
    /**
     * Handle the event.
     */
    public function handle(InitProcessToBuildLotCardsMemberEvent $event): void
    {
        $jobs = [];

        if($event->data !== []){

            $members = $event->data;

        }
        else{

            $members = getMembers();

        }

        foreach($members as $key => $member){

            $jobs[] = new JobBuildCardMember($member, $key, $event->admin_generator);

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

                $progress = $batch->progress();

                $message_to_creator = $progress . " % des cartes émises!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "L'émission des cartes de membres en masse s'est achevée avec succès!";

                MembersCardsCreationCompletedSucessfullyEvent::dispatch($event->admin_generator, $message_to_creator);

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "L'émission des cartes de membres en masse a échoué";                

                MembersCardsCreationFailedEvent::dispatch($event->admin_generator, $message_to_creator);

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('members_cards_creation')->dispatch();
    }
}
