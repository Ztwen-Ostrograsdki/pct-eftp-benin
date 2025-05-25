<?php

namespace App\Observers;

use App\Events\UpdateCommuniquesListEvent;
use App\Models\Communique;

class ObserveCommunique
{
    /**
     * Handle the Communique "created" event.
     */
    public function created(Communique $communique): void
    {
        UpdateCommuniquesListEvent::dispatch();
    }

    /**
     * Handle the Communique "updated" event.
     */
    public function updated(Communique $communique): void
    {
        UpdateCommuniquesListEvent::dispatch();
    }

    /**
     * Handle the Communique "deleted" event.
     */
    public function deleted(Communique $communique): void
    {
        UpdateCommuniquesListEvent::dispatch();
    }

    /**
     * Handle the Communique "restored" event.
     */
    public function restored(Communique $communique): void
    {
        //
    }

    /**
     * Handle the Communique "force deleted" event.
     */
    public function forceDeleted(Communique $communique): void
    {
        //
    }
}
