<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerificationKeyToUser extends Notification
{
    use Queueable;

    public $key;

    /**
     * Create a new notification instance.
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Bonjour Mr/Mme' . $notifiable->getFullName())
                    ->line('Vous recevez ce courriel parce que')
                    ->line("Vous avez lancer l'inscription sur " . config('app.name') . " avec l'addresse : " . $notifiable->email)
                    ->action('Confirmez votre compte', url(route('email.verification', ['email' => $notifiable->email, 'key' => $this->key])))
                    ->line('La clé est :' . $this->key)
                    ->line('Merci pour votre fidélité');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
