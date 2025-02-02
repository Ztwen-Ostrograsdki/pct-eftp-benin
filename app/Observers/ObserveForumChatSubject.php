<?php

namespace App\Observers;

use App\Helpers\Tools\ModelsRobots;
use App\Models\ENotification;
use App\Models\ForumChatSubject;

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

        $since = $forumChatSubject->__getDateAsString($forumChatSubject->created_at, 3, true);

        $object = "Validation d'un sujet de discussion publié sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
        " et d'identifiant personnel : ID = " . $user->identifiant;

        $content = "Vous recevez cette notification parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer ce sujet de discussion publié par "
        . $user->getUserNamePrefix() . " " . $user->getFullName(true) . ". Ce sujet de discussion a été publié le " . $since . " ." ;
        
        $title = "Validation d'un sujet de discussion publié";
        
        $data = [
            'user_id' => $user->id,
            'content' => $content,
            'title' => $title,
            'object' => $object,
            'receivers' => $admins,

        ];

        ENotification::create($data);
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
