<?php

namespace App\Observers;

use App\Events\IHaveNewNotificationEvent;
use App\Events\ToasterMessagesEvent;
use App\Models\ENotification;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Str;

class ObserveENotification
{
    /**
     * Handle the ENotification "created" event.
     */
    public function created(ENotification $eNotification): void
    {

        $receivers = $eNotification->getReceivers();

        $content = "Une nouvelle notification: " . string_cutter($eNotification->object, 10);

        foreach($receivers as $user){

            $user->notify(new RealTimeNotificationGetToUser($content));
            
            IHaveNewNotificationEvent::dispatch($user);
        }
        
    }

    /**
     * Handle the ENotification "updated" event.
     */
    public function updated(ENotification $eNotification): void
    {
        //
    }

    /**
     * Handle the ENotification "deleted" event.
     */
    public function deleted(ENotification $eNotification): void
    {
        //
    }

    /**
     * Handle the ENotification "restored" event.
     */
    public function restored(ENotification $eNotification): void
    {
        //
    }

    /**
     * Handle the ENotification "force deleted" event.
     */
    public function forceDeleted(ENotification $eNotification): void
    {
        //
    }
}
