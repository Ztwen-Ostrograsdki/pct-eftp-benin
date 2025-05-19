<?php

namespace App\Observers;

use App\Events\NewCardMemberHasBeenCreatedEvent;
use App\Models\CardMember;
use App\Notifications\RealTimeNotificationGetToUser;

class ObserveCardMember
{
    /**
     * Handle the CardMember "created" event.
     */
    public function created(CardMember $cardMember): void
    {

        $admin_generator = $cardMember->getCreator();

        $member = $cardMember->member;

        $message_to_creator = "La carte de " . $member->user->getFullName() . " a été finalisée et envoyée avec succès!";

        $message_to_member = "Veuillez vérifier votre boite mail: votre carte vous a été envoyée par couriel!";


        NewCardMemberHasBeenCreatedEvent::dispatch($cardMember->member, $admin_generator);

        $admin_generator->notify(new RealTimeNotificationGetToUser($message_to_creator));

        // $member->user->notify(new RealTimeNotificationGetToUser($message_to_member));
    }

    /**
     * Handle the CardMember "updated" event.
     */
    public function updated(CardMember $cardMember): void
    {
        //
    }

    /**
     * Handle the CardMember "deleted" event.
     */
    public function deleted(CardMember $cardMember): void
    {
        //
    }

    /**
     * Handle the CardMember "restored" event.
     */
    public function restored(CardMember $cardMember): void
    {
        //
    }

    /**
     * Handle the CardMember "force deleted" event.
     */
    public function forceDeleted(CardMember $cardMember): void
    {
        //
    }
}
