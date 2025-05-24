<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\YourCardMemberIsReadyMail;
use App\Models\Member;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class JobToSendCardMemberToMemberByEmail implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Member $member,
        public User $admin_generator
    )
    {
        $this->member = $member;

        $this->admin_generator = $admin_generator;
    }

    public function handle()
    {

        if(__isConnectedToInternet()){

            $send_mail = self::sendCardToMemberByEmail();

            if($send_mail){

                $message_to_creator = "La carte de " . $this->member->user->getFullName() . " a été envoyée avec succès!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));
            }
            else{

                $message_to_creator = "Une erreur s'est produite: la carte de " . $this->member->user->getFullName() . " n'a pas été envoyée!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            }
            
        }
        else{

            $message_to_creator = "La carte de " . $this->member->user->getFullName() . " n'a pas été envoyée car vous n'êtes pas connecté à internet!";

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

        }

        
    }


    public function sendCardToMemberByEmail()
    {

        $user = $this->member->user;

        $card = $this->member->card();

        if($card){

            $association = env('APP_NAME');

            $lien = route('user.profil', ['identifiant' => $user->identifiant]);

            $html = EmailTemplateBuilder::render('member-card', [
                'name' => $user->getFullName(true),
                'poste' => $user->getMemberRoleName(),
                'association' => $association,
                'lien' => $lien,
                'email' => $user->email,
                'identifiant' => $user->identifiant
            ]);

            $send = Mail::to($user->email)->send(new YourCardMemberIsReadyMail($user, $card->card_path, $html));


            if($send){

                return $card->markAsSendToMemberByEmail();

            }

        }

        
    }

}
