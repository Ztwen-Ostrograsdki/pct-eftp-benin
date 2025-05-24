<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Helpers\Tools\ModelsRobots;
use App\Mail\SendCommnuniqueToMember;
use App\Models\Communique;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class JobToSendCommuniqueToMembers implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    public $timeout = 300;

    public function __construct(
        public User $user,
        public User $admin_generator,
        public Communique $communique,

    )
    {
        $this->$user = $user;

        $this->admin_generator = $admin_generator;

        $this->communique = $communique;
    }

    public function handle()
    {

        if(__isConnectedToInternet()){

            $send_mail = self::sendCommuniqueToMemberByEmail();

            if($send_mail){

                
            }
            else{

                

            }
            
        }
        else{

            

        }

        
    }


    public function sendCommuniqueToMemberByEmail()
    {

        $user = $this->user;

        $pdf = $this->communique->pdf_path;

        $communique = $this->communique;

        if($pdf){

            $association = env('APP_NAME');

            $lien = route('user.profil', ['identifiant' => $user->identifiant]);

            $greating = ModelsRobots::greatingMessage($user->getUserNamePrefix(true, false));

            $html = EmailTemplateBuilder::render('communique', [
                'name' => $user->getFullName(true),
                'poste' => $user->getMemberRoleName(),
                'association' => $association,
                'lien' => $lien,
                'objet' => $communique->objet,
                'greating' => $greating,
            ]);

            $send = Mail::to($user->email)->send(new SendCommnuniqueToMember($user, $communique, $html));

        }

        
    }
}
