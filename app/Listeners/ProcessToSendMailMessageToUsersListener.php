<?php

namespace App\Listeners;

use App\Events\InitProcessToSendSimpleMailMessageToUsersEvent;
use App\Jobs\JobToSendSimpleMailMessageTo;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ProcessToSendMailMessageToUsersListener
{
    /**
     * Handle the event.
     */
    public function handle(InitProcessToSendSimpleMailMessageToUsersEvent $event): void
    {
        $receivers_details = $event->receivers_details;

        $jobs = [];

        if(!empty($receivers_details)){

            foreach($receivers_details as $receiver){

                $email = $receiver['email'];

                $full_name = $receiver['full_name'];

                $message = $receiver['message'];

                $file_to_attach = $receiver['file_to_attach'];

                $lien = $receiver['lien'];

                $jobs[] = new JobToSendSimpleMailMessageTo($email, $full_name, $message, $file_to_attach, $lien);

            }
        }
        elseif($event->receiver_mail){

            $email = $event->receiver_mail;

            $full_name = $event->receiver_full_name;

            $message = $event->message;

            $file_to_attach = $event->file_to_attach_path;

            $lien = $event->lien;

            $jobs[] = new JobToSendSimpleMailMessageTo($email, $full_name, $message, $file_to_attach, $lien);

        }

        $batch = Bus::batch($jobs)
            ->then(function(Batch $batch) use ($event){

                
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){
                

            })

            ->finally(function(Batch $batch){


        })->name('simple_mail_message_sender')->dispatch();
    }
}
