<?php

namespace App\Listeners;

use App\Events\ForumChatSujectHasBeenSubmittedSuccessfullyEvent;
use App\Events\NewForumChatSubjectDispachedByUserEvent;
use App\Jobs\JobDispatchForumChatSubject;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class NewForumChatSubjectDispachedByUserListener
{
   

    /**
     * Handle the event.
     */
    public function handle(NewForumChatSubjectDispachedByUserEvent $event): void
    {
        $batch = Bus::batch([

            new JobDispatchForumChatSubject($event->user, $event->data),

            ])->then(function(Batch $batch) use ($event){

                ForumChatSujectHasBeenSubmittedSuccessfullyEvent::dispatch($event->user, $event->data);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

            })

            ->finally(function(Batch $batch){


        })->name('new_subject_into_forum_chat_box')->dispatch();
    }
}
