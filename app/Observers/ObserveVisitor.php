<?php

namespace App\Observers;

use App\Events\NewVisitorHasBeenRegistredEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\Visitor;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\Notification;

class ObserveVisitor
{
    /**
     * Handle the Visitor "created" event.
     */
    public function created(Visitor $visitor): void
    {
        NewVisitorHasBeenRegistredEvent::dispatch();

        $admins = ModelsRobots::getAllAdmins();

        Notification::sendNow($admins, new RealTimeNotificationGetToUser("Un nouvel visiteur a été enregistré sur la plateforme!"));
    }

    /**
     * Handle the Visitor "updated" event.
     */
    public function updated(Visitor $visitor): void
    {
        NewVisitorHasBeenRegistredEvent::dispatch();
    }

    /**
     * Handle the Visitor "deleted" event.
     */
    public function deleted(Visitor $visitor): void
    {
        //
    }

    /**
     * Handle the Visitor "restored" event.
     */
    public function restored(Visitor $visitor): void
    {
        //
    }

    /**
     * Handle the Visitor "force deleted" event.
     */
    public function forceDeleted(Visitor $visitor): void
    {
        //
    }
}
