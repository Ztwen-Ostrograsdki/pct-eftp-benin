<?php

namespace App\Observers;

use App\Events\UpdateUsersListToComponentsEvent;
use App\Jobs\JobLogoutUser;
use App\Jobs\JobToGenerateDefaultUserMember;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ObserveUser
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);

        JobToGenerateDefaultUserMember::dispatch($user)->delay(Carbon::now()->addMinutes(10));

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);

        if($user->emailVerified() && $user->confirmed_by_admin){
            JobToGenerateDefaultUserMember::dispatch($user)->delay(Carbon::now()->addMinutes(10));
        }
        
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        UpdateUsersListToComponentsEvent::dispatch();
    }
    
    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        if($user->emailVerified() && $user->confirmed_by_admin){
            JobToGenerateDefaultUserMember::dispatch($user)->delay(Carbon::now()->addMinutes(10));
        }
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        UpdateUsersListToComponentsEvent::dispatch();
    }
}
