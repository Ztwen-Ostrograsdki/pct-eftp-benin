<?php

namespace App\Observers;

use App\Jobs\JobLogoutUser;
use App\Models\User;
use Illuminate\Support\Str;

class ObserveUser
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
