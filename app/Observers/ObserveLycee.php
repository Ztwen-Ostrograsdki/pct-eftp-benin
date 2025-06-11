<?php

namespace App\Observers;

use App\Events\UpdatedLyceesDataEvent;
use App\Models\Lycee;

class ObserveLycee
{
    /**
     * Handle the Lycee "created" event.
     */
    public function created(Lycee $lycee): void
    {
        UpdatedLyceesDataEvent::dispatch();
    }

    /**
     * Handle the Lycee "updated" event.
     */
    public function updated(Lycee $lycee): void
    {
        UpdatedLyceesDataEvent::dispatch();
    }

    /**
     * Handle the Lycee "deleted" event.
     */
    public function deleted(Lycee $lycee): void
    {
        UpdatedLyceesDataEvent::dispatch();
    }

    /**
     * Handle the Lycee "restored" event.
     */
    public function restored(Lycee $lycee): void
    {
        //
    }

    /**
     * Handle the Lycee "force deleted" event.
     */
    public function forceDeleted(Lycee $lycee): void
    {
        //
    }
}
