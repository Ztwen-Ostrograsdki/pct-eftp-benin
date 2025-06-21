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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class JobBuildCardMember implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    public $timeout = 300;

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

        try {

            self::doJob();
            
        } catch (\Exception $e) {
            Log::error("Erreur dans JobBuildCardMember: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'member_id' => $this->member->id,
                'user_id' => $this->member->user->id ?? null,
            ]);

            $message = "Erreur lors de la génération de la carte de " . $this->member->user->getFullName();

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message));

            $this->fail($e); // marque le job comme failed pour tracking
        }
    }


    public function doJob()
    {

        $member = $this->member;

        $user = $member->user;

        $card_number = date('Y') . '' . generateRandomNumber(6);

        $qr_value = 'ID:' . $user->identifiant . '@Tel:' . $user->contacts . 'N°:' . $card_number;

        $qrcode = QrCode::size(80)->generate($qr_value);

        $expired_at = Carbon::now()->addYears(3);

        // Configure la locale française
        Carbon::setLocale('fr');

        // Crée la date actuelle avec timezone (exemple Africa/Abidjan)
        $now = Carbon::now('Africa/Abidjan');

        $name = env('APP_NAME');

        
        $formattedDate = 'Générée et imprimée sur la plateforme ' . $name . ' le ' 
            . $now->isoFormat('dddd D MMMM YYYY')  // Ex: lundi 25 mai 2025
            . ' à ' 
            . $now->isoFormat('HH\H mm\min ss\s'); // Ex: 10H 15min 24s

        $header_title = " CARTE DE MEMBRE DE " . $user->getFullName() . "Générée et imprimée sur la plateforme " . $name;

        $headerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:gray;">'
            . $header_title
            . '</div>';

        $footerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:black;">'
            . $formattedDate
            . '</div>';

        if($user->member->role) $role = $member->role->name;
        else $role = "Membre";

        $data = [
            'name' => $user->getFullName(),
            'reverse_name' => $user->getFullName(true),
            'email' =>  $user->email,
            'identifiant' =>  $user->identifiant,
            'address' =>  Str::upper($user->address),
            'role' =>  $role,
            'photo' =>  user_profil_photo($user),
            'contacts' =>  $user->contacts,
            'card_number' => $card_number,
            'qrcode' => $qrcode,
            'expired_at' => $expired_at,

        ];

        $html = View::make('pdftemplates.card', $data)->render();

        $root = storage_path("app/public/cartes");

        if(!File::isDirectory($root)){

            $directory_make = File::makeDirectory($root, 0777, true, true);

        }

        if(!File::isDirectory($root) && !$directory_make){

            $this->fail();

        }

        $year = (int)date('Y'); 

        $duration = $year . '-' . $year + 3;

        $path = Str::replace(' ', '-', $user->getFullName()) . "-" . $duration . '.pdf';

        ini_set("max_execution_time", 300);

        
        $pdfPath = storage_path("app/public/cartes/carte-de-membre-de-". $path);

        Browsershot::html($html)
            ->waitUntilNetworkIdle()
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setNpmBinary('C:\Program Files\nodejs\npm.cmd')
            ->setIncludePath(public_path('build/assets'))
            ->showBackground()
            ->ignoreHttpsErrors()
            ->format('A4')
            ->margins(25, 25, 25, 25)
            ->showBrowserHeaderAndFooter() // Active l'affichage du header/footer
            ->headerHtml($headerHtml)
            ->footerHtml($footerHtml)
            ->save($pdfPath);

        $done = File::exists($pdfPath);

        if($done){

            $key = generateRandomNumber(5);

            $card_of_this_year_existed = $member->card();

            $card_deleted = true;

            $card_created = true;

            if($card_of_this_year_existed){

                $card_deleted = $card_of_this_year_existed->delete();

            }

            if($card_deleted){

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
                    'card_path' => $pdfPath,
                    'print_blocked' => false,
                    'key' => $key,

                ];

                $card_created = CardMember::create($db_data);
            }

            if(!$card_created){

                deleteFileIfExists($pdfPath);

                $message_to_creator = "La carte de " . $member->user->getFullName() . " n'a pas pu être générée!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

                $this->fail();

            }

        }
    }

    

}


