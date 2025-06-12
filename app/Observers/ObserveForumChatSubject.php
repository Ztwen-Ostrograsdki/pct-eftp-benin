<?php

namespace App\Observers;

use App\Events\ToasterMessagesEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\ForumChatSubject;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ObserveForumChatSubject
{
    /**
     * Handle the ForumChatSubject "created" event.
     */
    public function created(ForumChatSubject $forumChatSubject): void
    {
        ModelsRobots::notificationToAdminsThatNewForumChatSubjectPublished($forumChatSubject->user, $forumChatSubject);

        $admins = ModelsRobots::getUserAdmins();

        $user = $forumChatSubject->user;

        $since = __formatDateTime($forumChatSubject->created_at);

        $message = "Approbation d'un sujet de discussion publiée par l'utilisateur " . $user->getUserNamePrefix() . " " . $user->getFullName(true)  . " du compte : " . $user->email . ". Le sujet a été publié le " . $since . " .";

        Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));
        
    }

    /**
     * Handle the ForumChatSubject "updated" event.
     */
    public function updated(ForumChatSubject $forumChatSubject): void
    {
        //
    }

    /**
     * Handle the ForumChatSubject "deleted" event.
     */
    public function deleted(ForumChatSubject $forumChatSubject): void
    {
        //
    }

    /**
     * Handle the ForumChatSubject "restored" event.
     */
    public function restored(ForumChatSubject $forumChatSubject): void
    {
        //
    }

    /**
     * Handle the ForumChatSubject "force deleted" event.
     */
    public function forceDeleted(ForumChatSubject $forumChatSubject): void
    {
        //
    }
}
