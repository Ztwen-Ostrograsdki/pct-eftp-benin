<?php

namespace App\Observers;

use App\Events\UpdateLawEcosystemEvent;
use App\Models\LawArticle;

class ObserveLawArticle
{
    /**
     * Handle the LawArticle "created" event.
     */
    public function created(LawArticle $lawArticle): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawArticle "updated" event.
     */
    public function updated(LawArticle $lawArticle): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawArticle "deleted" event.
     */
    public function deleted(LawArticle $lawArticle): void
    {
        $user = auth_user();
        
        UpdateLawEcosystemEvent::dispatch($user);
    }

    /**
     * Handle the LawArticle "restored" event.
     */
    public function restored(LawArticle $lawArticle): void
    {
        //
    }

    /**
     * Handle the LawArticle "force deleted" event.
     */
    public function forceDeleted(LawArticle $lawArticle): void
    {
        //
    }
}
