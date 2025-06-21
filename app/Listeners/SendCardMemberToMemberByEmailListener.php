<?php

namespace App\Listeners;

use App\Events\NewCardMemberHasBeenCreatedEvent;
use App\Jobs\JobToSendCardMemberToMemberByEmail;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class SendCardMemberToMemberByEmailListener
{

    /**
     * Handle the event.
     */
    public function handle(NewCardMemberHasBeenCreatedEvent $event): void
    {
         $batch = Bus::batch([

            new JobToSendCardMemberToMemberByEmail($event->member,  $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('send_card_member_to_member')->dispatch();
    }
}
