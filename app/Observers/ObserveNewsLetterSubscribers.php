<?php

namespace App\Observers;

use App\Jobs\JobToSendWelcomeMessageToNewsLetterSubscriber;
use App\Models\NewsLetterSubscribers;

class ObserveNewsLetterSubscribers
{
    /**
     * Handle the NewsLetterSubscribers "created" event.
     */
    public function created(NewsLetterSubscribers $newsLetterSubscribers): void
    {
        $email = $newsLetterSubscribers->email;

        JobToSendWelcomeMessageToNewsLetterSubscriber::dispatch($email);
    }

    /**
     * Handle the NewsLetterSubscribers "updated" event.
     */
    public function updated(NewsLetterSubscribers $newsLetterSubscribers): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscribers "deleted" event.
     */
    public function deleted(NewsLetterSubscribers $newsLetterSubscribers): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscribers "restored" event.
     */
    public function restored(NewsLetterSubscribers $newsLetterSubscribers): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscribers "force deleted" event.
     */
    public function forceDeleted(NewsLetterSubscribers $newsLetterSubscribers): void
    {
        //
    }
}
