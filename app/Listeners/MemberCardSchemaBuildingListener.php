<?php

namespace App\Listeners;

use App\Events\InitMemberCardSchemaEvent;
use App\Events\MembersCardCreationCompletedEvent;
use App\Events\MembersCardCreationFailedEvent;
use App\Jobs\JobBuildCardMember;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class MemberCardSchemaBuildingListener
{

    /**
     * Handle the event.
     */
    public function handle(InitMemberCardSchemaEvent $event): void
    {
        $batch = Bus::batch([

            new JobBuildCardMember($event->member, $event->key, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                MembersCardCreationCompletedEvent::dispatch($event->member, $event->admin_generator);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                MembersCardCreationFailedEvent::dispatch($event->member, $event->admin_generator, "L'émission de la carte de membre de " . $event->member->user->getFullName() . " a échoué!");

            })

            ->finally(function(Batch $batch){


        })->name('member_card_creation')->dispatch();
    }
}
