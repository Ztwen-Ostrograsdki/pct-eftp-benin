<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDocumentToMemberMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public $document_path,
        public $objet,
        public $html,
    )
    {
        $this->user = $user;

        $this->document_path = $document_path;

        $this->objet = $objet;

        $this->html = $html;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjet = $this->objet;

        return new Envelope(
            subject: $subjet
        );
    }


    public function build()
    {
        $subjet = $this->objet;

        return $this->subject($subjet)
                    ->html($this->html);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->document_path)
            ->withMime('application/pdf'),
        ];
    }
}
