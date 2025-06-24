<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\SendSimpleMailMessageMail;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobToSendSimpleMailMessageTo implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $email,
        public $full_name,
        public $message,
        public $file_to_attach_path = null,
        public $lien = null
    )
    {
        $this->email = $email;

        $this->full_name = $full_name;

        $this->message = $message;

        $this->lien = $lien;

        $this->file_to_attach_path = $file_to_attach_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lien = $this->lien ? $this->lien : route('home');

        $html = EmailTemplateBuilder::render('simple-mail-message', [
            'lien' => $lien,
            'full_name' => $this->full_name,
            'message' => $this->message,
        ]);

        Mail::to($this->email)->send(new SendSimpleMailMessageMail($this->email, $this->full_name, $this->message, $this->file_to_attach_path, $html));
    }
}
