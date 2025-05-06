<?php

namespace App\Observers;

use App\Models\ForumChat;
use App\Notifications\RealTimeNotificationGetToUser;

class ObserveChatForumMessage
{
    /**
     * Handle the ForumChat "created" event.
     */
    public function created(ForumChat $forumChat): void
    {
        if($forumChat->reply_to_message_id){

            $user_id = auth_user()->id;

            if($user_id !== $forumChat->user->id){

                $targeted_message = ForumChat::find($forumChat->targeted_message_id);

                if($targeted_message){

                    $targeted_user = $targeted_message->user;

                    if($targeted_user){

                        $replyer = $forumChat->user;

                        $replyer_name = $replyer->getFullName();

                        $targeted_user->notify(new RealTimeNotificationGetToUser($replyer_name . " a repondu à votre message dans le forum!"));

                    }

                    
                }
            }

        }
    }

    /**
     * Handle the ForumChat "updated" event.
     */
    public function updated(ForumChat $forumChat): void
    {
        //
    }

    /**
     * Handle the ForumChat "deleted" event.
     */
    public function deleted(ForumChat $forumChat): void
    {
        //
    }

    /**
     * Handle the ForumChat "restored" event.
     */
    public function restored(ForumChat $forumChat): void
    {
        //
    }

    /**
     * Handle the ForumChat "force deleted" event.
     */
    public function forceDeleted(ForumChat $forumChat): void
    {
        //
    }
}
