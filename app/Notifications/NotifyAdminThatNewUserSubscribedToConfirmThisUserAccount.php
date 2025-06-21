<?php

namespace App\Notifications;

use App\Helpers\Tools\ModelsRobots;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount extends Notification
{
    use Queueable;

    public $user_to_confirm;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user_to_confirm)
    {
        $this->user_to_confirm = $user_to_confirm;
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
        $user = $this->user_to_confirm;

        $salutation = ModelsRobots::greatingMessage($notifiable->getUserNamePrefix(true, false));

        $since = $user->__getDateAsString($user->email_verified_at, 3, true);

        return (new MailMessage)
            ->subject("Nouvelle inscription sur la plateforme. Utilisateur: " . $user->getFullName())
            ->greeting($salutation)
            ->line('Vous recevez ce courriel parce que vous êtes un administrateur actif de la plateforme ' . config('app.name') . '!')
            ->line("L'utilisateur " . $user->getFullName() . " dont l'adresse mail est " . $user->email . " vient de valider son adresse mail!")
            ->line("Son compte n'a pas encore été approuvé ou validé depuis la validation de son inscription faite le " . $since)
            ->line("Vous pouvez procéder à la validation ou non de ce compte;")
            ->action("Proccéder à l'analyse du compte de " . $user->getFullName() . " !" , url(route('user.profil', ['identifiant' => $user->identifiant])));
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
