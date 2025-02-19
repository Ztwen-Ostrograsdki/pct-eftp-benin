<?php

namespace App\Notifications;

use App\Helpers\Tools\ModelsRobots;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDynamicMailToUser extends Notification
{
    use Queueable;

    public $sub;

    public $bod;

    /**
     * Create a new notification instance.
     */
    public function __construct($subjet, $body)
    {
        $this->sub = $subjet;

        $this->bod = $body;
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
                    ->greeting($salutation)
                    ->subject(__($this->sub))
                    ->line(__($this->bod))
                    ->line(__('Merci de prendre en compte ce mail'))
                    ->line("Ensemble développons notre communauté scientifique !!!");
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
