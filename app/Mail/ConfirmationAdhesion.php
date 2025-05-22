<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationAdhesion extends Mailable
{
    use Queueable, SerializesModels;

    public $nom, $poste, $association, $lien, $html;

    /**
     * Create a new message instance.
     */
    public function __construct($nom, $poste, $association, $lien, $html)
    {
        $this->nom = $nom;
        $this->poste = $poste;
        $this->association = $association;
        $this->lien = $lien;
        $this->html = $html;
    }

    public function build()
    {
        return $this->subject("Bonjour  $this->association")
                    ->html($this->html)
                    ->with([
                        'nom' => $this->nom,
                        'poste' => $this->poste,
                        'association' => $this->association,
                        'lien' => $this->lien,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation Adhesion',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
