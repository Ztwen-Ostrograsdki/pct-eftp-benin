<?php

namespace App\Listeners;

use App\Events\ChatMessageHasBeenSentSuccessfullyEvent;
use App\Events\NewChatMessageIntoForumEvent;
use App\Jobs\JobSendNewChatMessageIntoForum;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class NewChatMessageIntoForumListener
{
   

    /**
     * Handle the event.
     */
    public function handle(NewChatMessageIntoForumEvent $event): void
    {
        $batch = Bus::batch([

            new JobSendNewChatMessageIntoForum($event->user, $event->data),

            ])->then(function(Batch $batch) use ($event){

                ChatMessageHasBeenSentSuccessfullyEvent::dispatch($event->user, $event->data);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('new_message_into_forum_chat_box')->dispatch();
    }
}
