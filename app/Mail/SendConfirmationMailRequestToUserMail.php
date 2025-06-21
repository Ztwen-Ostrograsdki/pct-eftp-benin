<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendConfirmationMailRequestToUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $user,
        public $key,
        public $html,
    )
    {
        $this->user = $user;

        $this->html = $html;

        $this->key = $key;
    }

    public function build()
    {
        $user = $this->user;

        $name = $user->getFullName(true);

        return $this->subject("Bonjour  $name")
                    ->html($this->html);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Votre clé de confirmation de l'address mail",
        );
    }

   
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            
        ];
    }
}
