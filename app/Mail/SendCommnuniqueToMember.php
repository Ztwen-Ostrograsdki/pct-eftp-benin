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

class SendCommnuniqueToMember extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public Communique $communique,
        public $html,
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
        $subjet = $this->communique->getCommuniqueFormattedName() . ' : ' . $this->communique->objet;

        return new Envelope(
            subject: $subjet
        );
    }


    public function build()
    {
        $subjet = $this->communique->getCommuniqueFormattedName() . ' : ' . $this->communique->objet;

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
            Attachment::fromPath($this->communique->pdf_path)
            ->withMime('application/pdf'),
        ];
    }
}
