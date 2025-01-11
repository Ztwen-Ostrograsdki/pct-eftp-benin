<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserThatAccountHasBeenConfirmedByAdmins extends Notification
{
    use Queueable;

    public $is_confirmed = true;

    /**
     * Create a new notification instance.
     */
    public function __construct($is_confirmed = true)
    {
        $this->is_confirmed = $is_confirmed;
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
        ->subject("Confirmation de l'indentification utilisateur de la plateforme" . config('app.name') . " du compte " . $notifiable->email)
        ->line('Félicitation Mr/Mme' . $notifiable->getFullName())
        ->line("Nous vous informons que votre comte a été confirmé avec succès!")
        ->line("Votre identifiant unique de la plateforme est " . $notifiable->identifiant . " !")
        ->line("Vous pouvez à présent vous connecter !")
        ->action('Je me connecte ' , url(route('login', ['email' => $notifiable->email])))
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
