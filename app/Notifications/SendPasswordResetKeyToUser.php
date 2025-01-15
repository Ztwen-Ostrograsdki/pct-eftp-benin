<?php

namespace App\Notifications;

use App\Helpers\Tools\ModelsRobots;
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
        $salutation = ModelsRobots::greatingMessage($notifiable->getUserNamePrefix(true, false));
        
        return (new MailMessage)
                    ->subject("Réinitialisation mot de passe utilisateur de la plateforme " . config('app.name') . " du compte " . $notifiable->email)
                    ->greeting($salutation)
                    ->line('Vous recevez ce courriel parce que')
                    ->line('Vous avez fait une demande de réinitialisation de votre mot de passe du compte ' . $notifiable->email)
                    ->action('Réinitialiser mon mot de passe', url(route('password.reset.by.email', ['email' => $notifiable->email, 'key' => $this->key])))
                    ->line('La clé est : ' . $this->key)
                    ->line("Ensemble développons de notre communauté scientifique !!!");
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
