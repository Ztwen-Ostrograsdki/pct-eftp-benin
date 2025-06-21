<?php

namespace App\Observers;

use App\Events\IHaveNewNotificationEvent;
use App\Models\ENotification;
use App\Notifications\RealTimeNotificationGetToUser;

class ObserveENotification
{
    /**
     * Handle the ENotification "created" event.
     */
    public function created(ENotification $eNotification): void
    {

        $eNotification->delete();
        
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
