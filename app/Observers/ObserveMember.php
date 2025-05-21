<?php

namespace App\Observers;

use App\Events\UpdateMembersListEvent;
use App\Models\Member;

class ObserveMember
{
    /**
     * Handle the Member "created" event.
     */
    public function created(Member $member): void
    {
        UpdateMembersListEvent::dispatch($member->user);
    }

    /**
     * Handle the Member "updated" event.
     */
    public function updated(Member $member): void
    {
        UpdateMembersListEvent::dispatch($member->user);
    }

    /**
     * Handle the Member "deleted" event.
     */
    public function deleting(Member $member): void
    {
        UpdateMembersListEvent::dispatch($member->user);
    }

    /**
     * Handle the Member "restored" event.
     */
    public function restored(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "force deleted" event.
     */
    public function forceDeleted(Member $member): void
    {
        //
    }
}
