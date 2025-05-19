<?php

namespace App\Jobs;

use App\Mail\YourCardMemberIsReadyMail;
use App\Models\CardMember;
use App\Models\Member;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class JobBuildCardMember implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $member,
        public $key,
        public $admin_generator
    )
    {
        $this->member = $member;

        $this->key = $key;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $message_to_creator = "Initialisation de la procédure...";

        // Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

        $member = $this->member;

        $user = $member->user;

        $card_number = date('Y') . '' . random_int(10000002, 999999999999);

        $qr_value = 'ID:' . $user->identifiant . '@Tel:' . $user->contacts . 'N°:' . $card_number;

        $qrcode = QrCode::size(80)->generate($qr_value);

        $card_number = date('Y') . '' . random_int(10000002, 999999999999);

        $expired_at = Carbon::now()->addYears(3);

        $data = [
            'name' => $user->getFullName(),
            'reverse_name' => $user->getFullName(true),
            'email' =>  $user->email,
            'identifiant' =>  $user->identifiant,
            'address' =>  Str::upper($user->address),
            'role' =>  $member->role->name,
            'photo' =>  user_profil_photo($user),
            'contacts' =>  $user->contacts,
            'card_number' => $card_number,
            'qrcode' => $qrcode,
            'expired_at' => $expired_at

        ];

        $html = View::make('pdftemplates.card', $data)->render();

        $root = storage_path("app/public/cartes");

        if(!File::isDirectory($root)){

            $directory_make = File::makeDirectory($root, 0777, true, true);

        }

        if(!File::isDirectory($root) && !$directory_make){

            $this->fail();

        }

        $path = Str::replace(' ', '-', $user->getFullName()) . "-" . $card_number . '.pdf';

        
        $pdfPath = storage_path("app/public/cartes/carte-de-membre-de-". $path);

        ini_set("max_execution_time", 120);

        Browsershot::html($html)
            ->waitUntilNetworkIdle()
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setNpmBinary('C:\Program Files\nodejs\npm.cmd')
            ->setIncludePath(public_path('build/assets'))
            ->showBackground()
            ->ignoreHttpsErrors()
            ->format('A4')
            ->margins(15, 15, 15, 15)
            ->save($pdfPath);

        $done = response()->download($pdfPath);

        if($done){

            $message_to_creator = "Création de la carte en PDF...";

            // Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            $key = $this->key;

            $db_data = [
                'member_id' => $member->id,
                'card_number' => $card_number,
                'code_qr' => $qr_value,
                'expired' => false,
                'expired_at' => $expired_at,
                'generate_by' => $this->admin_generator->id,
                'closed_because_lost' => false,
                'declared_as_lost_at' => null,
                'last_print_date' => null,
                'total_print' => 0,
                'status' => $pdfPath,
                'print_blocked' => false,
                'key' => Hash::make($key),

            ];

            $card_created = CardMember::create($db_data);

            if($card_created){

                $message_to_creator = "Envoie des données dans la base de données...";

                // Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

                if(self::isConnectedToInternet()){

                    Mail::to($user->email)->send(new YourCardMemberIsReadyMail($user, $pdfPath));

                    $this->member->update(['card_sent_by_mail' => true]);
                    
                    $card_created->update(['card_sent_by_mail' => true]);
                    
                }
                else{

                    $message_to_creator = "La carte de " . $member->user->getFullName() . " a été finalisée et mais pas envoyée car vous n'êtes pas connecté à internet!";

                    Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

                }

            }
            else{

                deleteFileIfExists($pdfPath);

                $message_to_creator = "La carte de " . $member->user->getFullName() . " n'a pas pu être générée!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

                $this->fail();
                
            }

        }
        
    }

    protected function isConnectedToInternet() : bool
    {
        try {

           return @fsockopen("www.google.com", 80) !== false;

        } catch (\Exception $e) {

            return false;
        }
    }
}


