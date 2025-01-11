<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserThatOrderHasBeenApproved extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
        ->subject("Demande d'achat approuvée: Demande N° " . $this->order->identifiant)
        ->greeting('Bonjour Mr/Mme' . $notifiable->getFullName())
        ->line('Vous recevez ce courriel parce que')
        ->line("Votre demande d'achat N° " . $this->order->identifiant . " a été approuvée avec succès!")
        ->line("Vous pouvez procéder au payement")
        ->action('Proccéder au payement de la commande N° ' . $this->order->identifiant . " !" , url(route('user.checkout.success', ['identifiant' => $this->order->identifiant])))
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
