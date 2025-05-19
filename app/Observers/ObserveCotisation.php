<?php

namespace App\Observers;

use App\Events\MemberPaymentRequestCompletedEvent;
use App\Models\Cotisation;

class ObserveCotisation
{
    /**
     * Handle the Cotisation "created" event.
     */
    public function created(Cotisation $cotisation): void
    {
        //
    }

    /**
     * Handle the Cotisation "updated" event.
     */
    public function updated(Cotisation $cotisation): void
    {
        MemberPaymentRequestCompletedEvent::dispatch();
    }

    /**
     * Handle the Cotisation "deleted" event.
     */
    public function deleted(Cotisation $cotisation): void
    {
        MemberPaymentRequestCompletedEvent::dispatch();
    }

    /**
     * Handle the Cotisation "restored" event.
     */
    public function restored(Cotisation $cotisation): void
    {
        //
    }

    /**
     * Handle the Cotisation "force deleted" event.
     */
    public function forceDeleted(Cotisation $cotisation): void
    {
        //
    }
}
