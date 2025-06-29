<?php

namespace App\Notifications;

use App\Helpers\Tools\ModelsRobots;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;

class SendDynamicMailToUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $sub, 
        public $bod,
        public ?array $files_paths = [],

        )
    {
        $this->sub = $sub;

        $this->bod = $bod;

        $this->files_paths = $files_paths;
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
        
        $files_paths = $this->files_paths;

        if(empty($files_paths)){

            return (new MailMessage)
                    ->greeting($salutation)
                    ->subject(__($this->sub))
                    ->line(__($this->bod))
                    ->line(__('Merci de prendre en compte ce courriel'))
                    ->line("Ensemble développons notre communauté scientifique !!!");
        }
        else{

            $mail = (new MailMessage)
                    ->greeting($salutation)
                    ->subject(__($this->sub))
                    ->line(__($this->bod))
                    ->line(__('Merci de prendre en compte ce courriel'))
                    ->line(count($files_paths) > 1 ? 'Des fichiers ont été joints' : 'Un fichier a été joint');
                    
            foreach($files_paths as $file_path){

                if(File::exists($file_path)){
                    
                    $mail->attach($file_path, [
                        'as' => basename($file_path),
                        'mime' => mime_content_type($file_path)

                    ]);
                }
            }
                    
            return $mail->line("Ensemble développons notre communauté scientifique !!!");

        }
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
