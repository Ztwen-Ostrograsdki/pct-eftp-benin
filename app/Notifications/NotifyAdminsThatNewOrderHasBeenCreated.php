<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminsThatNewOrderHasBeenCreated extends Notification
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
        $user = $this->order->user;

        return (new MailMessage)
        ->subject("Nouvelle demande d'achat reçue: Demande N° " . $this->order->identifiant)
        ->greeting('Bonjour Mr/Mme' . $notifiable->getFullName())
        ->line('Vous recevez ce courriel parce que vous êtes un administrateur actif de ' . config('app.name') . '!')
        ->line("L'utilisateur " . $user->getFullName() . " dont l'adresse mail est " . $user->email . " a fait une demande d'achat!")
        ->line("La demande d'achat porte le N° " . $this->order->identifiant . " !")
        ->line("Vous pouvez procéder à la validation ou non cette demande en cliquant sur le liant ci-dessous;")
        ->action("Proccéder à l'analyse de la commande N° " . $this->order->identifiant . " !" , url(route('user.checkout.success', ['identifiant' => $this->order->identifiant])));
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
