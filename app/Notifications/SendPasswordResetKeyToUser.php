<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordResetKeyToUser extends Notification
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
                    ->line('Vous avez fait une demande de réinitialisation de votre mot de passe sur le compte' . $notifiable->email)
                    ->action('Réinitialiser mon mot de passe', url(route('password.reset.by.email', ['email' => $notifiable->email, 'key' => $this->key])))
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
