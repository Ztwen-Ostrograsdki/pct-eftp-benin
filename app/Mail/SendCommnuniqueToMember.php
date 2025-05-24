<?php

namespace App\Mail;

use App\Helpers\Tools\ModelsRobots;
use App\Models\Communique;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCommnuniqueToMember extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public Communique $communique,
        public string $html,
    )
    {
        $this->user = $user;

        $this->communique = $communique;

        $this->html = $html;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->communique && $this->communique->objet) ? $this->communique->objet : "Un Communiqué",
        );
    }


    public function build()
    {
        $subject = "Un communiqué";

        if($this->communique && $this->communique->objet) $subject = $this->communique->objet;

        return $this->subject($subject)
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
            Attachment::fromPath($this->communique->pdf_path)
            ->withMime('application/pdf'),
        ];
    }
}
