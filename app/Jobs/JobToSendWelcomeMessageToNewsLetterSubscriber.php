<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\SendWelcomeMailMessageToNewsLetterSubscriberMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobToSendWelcomeMessageToNewsLetterSubscriber implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $email
    )
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lien = route('home'); 

        $html = EmailTemplateBuilder::render('news-letter-subscriber-welcome-mail-message', [
            'lien' => $lien,
            'email' => $this->email,
        ]);

        Mail::to($this->email)->send(new SendWelcomeMailMessageToNewsLetterSubscriberMail($this->email, $html));
    }
}
