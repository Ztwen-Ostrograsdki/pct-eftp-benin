<?php

namespace App\Jobs;

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

        if(self::isConnectedToInternet()){

            $send_mail = self::sendCardToMemberByEmail();

            if($send_mail){

                $message_to_creator = "La carte de " . $this->member->user->getFullName() . " a été envoyée avec succès!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));
            }
            
        }
        else{

            $message_to_creator = "La carte de " . $this->member->user->getFullName() . " n'a pas été envoyée car vous n'êtes pas connecté à internet!";

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

        }

        
    }

    public function isConnectedToInternet() : bool
    {
        try {

           return @fsockopen("www.google.com", 80) !== false;

        } catch (\Exception $e) {

            return false;
        }
    }


    

    public function sendCardToMemberByEmail()
    {
        $message_to_creator = "Envoi de carte de membre de " . $this->member->user->getFullName() . " en cours...";

        Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

        $user = $this->member->user;

        $card = $this->member->card();

        if($card){

            $pdfPath = $card->card_path;

            $formattedDate = date('Y');

            $card_created = $card;

            $html = file_get_contents(base_path('resources/maizzle/build_production/member-card.html'));

            $name = $user->getFullName(true);

            $email = $user->email;

            $identifiant = $user->identifiant;

            $poste = $user->getMemberRoleName();

            $association = env('APP_NAME');

            $logo_path = public_path('images/logo.jpg');

            $type = pathinfo($logo_path, PATHINFO_EXTENSION);

            $data = file_get_contents($logo_path);

            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $lien = route('user.profil', ['identifiant' => $identifiant]);

            $html = str_replace(['{{ name }}', '{{ poste }}', '{{ association }}', '{{ lien }}', '{{ date }}', '{{ email }}', '{{ identifiant }}', '{{ logo_url }}'], [$name, $poste, $association, $lien, $formattedDate, $email, $identifiant, $base64], $html);

            $send = Mail::to($user->email)->send(new YourCardMemberIsReadyMail($user, $pdfPath, $html));

            if($send){

                $this->member->update(['card_sent_by_mail' => true]);
            
                $card_created->update(['card_sent_by_mail' => true]);

                return true;
            }

        }

        
    }

}
