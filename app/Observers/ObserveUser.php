<?php

namespace App\Observers;

use App\Events\UpdateUsersListToComponentsEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Jobs\JobToGenerateDefaultUserMember;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ObserveUser
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);

        JobToGenerateDefaultUserMember::dispatch($user)->delay(Carbon::now()->addMinutes(5));

        UpdateUsersListToComponentsEvent::dispatch();

        $admins = ModelsRobots::getAllAdmins();

        $message = "Une nouvelle inscription vient d'être faite sur la plateforme. Utilisateur : " . $user->getFullName(true) . " et Email: " . $user->email;

        Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if(Str::lower($user->status) == 'ame') $user->update(['is_ame' => true]);

        if($user->emailVerified() && $user->confirmed_by_admin && !$user->member){

            JobToGenerateDefaultUserMember::dispatch($user)->delay(Carbon::now()->addMinutes(5));

        }

        UpdateUsersListToComponentsEvent::dispatch();
        
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
