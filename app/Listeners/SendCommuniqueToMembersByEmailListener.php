<?php

namespace App\Listeners;

use App\Events\InitProcessToSendCommuniqueToMembersByMailEvent;
use App\Jobs\JobToSendCommuniqueToMembers;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendCommuniqueToMembersByEmailListener
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToSendCommuniqueToMembersByMailEvent $event): void
    {
        $jobs = [];

        if($event->receiver){

            $jobs[] = new JobToSendCommuniqueToMembers($event->receiver, $event->admin_generator, $event->communique);


        }
        else{

            $members = getMembers();

            foreach($members as $member){

                $jobs[] = new JobToSendCommuniqueToMembers($member->user, $event->admin_generator, $event->communique);

            }

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

                $progress = $batch->progress();

                $message_to_creator = $progress . " % mails envoyés!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "L'envoie du commniqué aux membres en masse par mail s'est achevée avec succès!";

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "L'envoie du commniqué aux membres en masse par mail a échoué!";                

                Notification::sendNow([$event->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('send_communique_to_members_by_mail')->dispatch();
    }
}
