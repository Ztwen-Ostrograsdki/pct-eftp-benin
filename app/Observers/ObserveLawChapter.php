<?php

namespace App\Observers;

use App\Events\UpdateLawEcosystemEvent;
use App\Models\LawChapter;

class ObserveLawChapter
{
    /**
     * Handle the LawChapter "created" event.
     */
    public function created(LawChapter $lawChapter): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawChapter "updated" event.
     */
    public function updated(LawChapter $lawChapter): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawChapter "deleted" event.
     */
    public function deleted(LawChapter $lawChapter): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawChapter "restored" event.
     */
    public function restored(LawChapter $lawChapter): void
    {
        //
    }

    /**
     * Handle the LawChapter "force deleted" event.
     */
    public function forceDeleted(LawChapter $lawChapter): void
    {
        //
    }
}
