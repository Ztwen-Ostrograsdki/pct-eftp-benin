<?php

namespace App\Observers;

use App\Events\MemberQuotesUpdatedEvent;
use App\Models\Quote;

class ObserveQuote
{
    /**
     * Handle the Quote "created" event.
     */
    public function created(Quote $quote): void
    {
        MemberQuotesUpdatedEvent::dispatch($quote->user, $quote->content, null);
    }

    /**
     * Handle the Quote "updated" event.
     */
    public function updated(Quote $quote): void
    {
        MemberQuotesUpdatedEvent::dispatch($quote->user, $quote->content, null);
    }

    /**
     * Handle the Quote "deleted" event.
     */
    public function deleted(Quote $quote): void
    {
        MemberQuotesUpdatedEvent::dispatch($quote->user, $quote->content, null);
    }

   
}
