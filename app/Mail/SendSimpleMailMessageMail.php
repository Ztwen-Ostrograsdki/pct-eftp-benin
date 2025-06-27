<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSimpleMailMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $email,
        public $full_name,
        public $message,
        public $objet,
        public $file_to_attach_path = null,
        public $html,
    )
    {
        $this->email = $email;

        $this->full_name = $full_name;

        $this->message = $message;

        $this->objet = $objet;

        $this->html = $html;

        $this->file_to_attach_path = $file_to_attach_path;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject($this->objet)
                    ->html($this->html);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vous avez reçu un mail!',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->file_to_attach_path){
            return [
                Attachment::fromPath($this->file_to_attach_path)
                ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
