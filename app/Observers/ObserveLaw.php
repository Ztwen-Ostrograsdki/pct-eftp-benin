<?php

namespace App\Observers;

use App\Events\UpdateLawEcosystemEvent;
use App\Models\Law;

class ObserveLaw
{
    /**
     * Handle the Law "created" event.
     */
    public function created(Law $law): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the Law "updated" event.
     */
    public function updated(Law $law): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the Law "deleted" event.
     */
    public function deleted(Law $law): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the Law "restored" event.
     */
    public function restored(Law $law): void
    {
        //
    }

    /**
     * Handle the Law "force deleted" event.
     */
    public function forceDeleted(Law $law): void
    {
        //
    }
}
