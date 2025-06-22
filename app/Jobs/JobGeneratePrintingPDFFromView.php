<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Helpers\Tools\ModelsRobots;
use App\Mail\SendDocumentToMemberMail;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class JobGeneratePrintingPDFFromView implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $view_path,
        public array $data,
        public $path,
        public ?User $user = null,
        public bool $send_by_mail = false,
        public ?User $admin_generator = null


    )
    {
        $this->user = $user;

        $this->path = $path;

        $this->view_path = $view_path;

        $this->data = $data;

        $this->send_by_mail = $send_by_mail;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        try {
            $document_done = self::pdfBuilder();

            if($document_done){

                if($this->send_by_mail){

                    self::sendDocumentToMemberByEmail();

                }
            }
            else{

                $this->fail();

            }


        } catch (\Throwable $e) {

            $message = "Erreur lors de la génération du document " . $this->data['document_title'] . $this->user ? " de " . $this->user->getFullName() : ' ' ;

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message));

            $this->fail($e); 
        }
    }


    protected function pdfBuilder()
    {
        $html = View::make($this->view_path, $this->data
        )->render();

        // Configure la locale française
        Carbon::setLocale('fr');

        // Crée la date actuelle avec timezone (exemple Africa/Abidjan)
        $now = Carbon::now('Africa/Abidjan');

        $name = env('APP_NAME');

        
        $formattedDate = 'Générée et imprimée sur la plateforme ' . $name . ' le ' 
            . $now->isoFormat('dddd D MMMM YYYY')  // Ex: lundi 25 mai 2025
            . ' à ' 
            . $now->isoFormat('HH\H mm\min ss\s'); // Ex: 10H 15min 24s

        $header_title = $this->data['document_title'] . ' Générée et imprimée sur la plateforme ' . $name;

        $headerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:gray;">'
            . $header_title
            . '</div>';

        $footerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:black;">'
            . $formattedDate
            . ' | Page <span class="pageNumber"></span> / <span class="totalPages"></span>'
            . '</div>';

        $pdfPath = $this->path;

        ini_set("max_execution_time", 300);

        Browsershot::html($html)
            ->waitUntilNetworkIdle()
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setNpmBinary('C:\Program Files\nodejs\npm.cmd')
            ->setIncludePath(public_path('build/assets'))
            ->showBackground()
            ->ignoreHttpsErrors()
            ->landscape()
            ->format('A4')
            ->margins(15, 15, 15, 15)
            ->showBrowserHeaderAndFooter() // Active l'affichage du header/footer
            ->headerHtml($headerHtml)
            ->footerHtml($footerHtml)
            ->save($pdfPath);

        return File::exists($pdfPath);
    }


    protected function sendDocumentToMemberByEmail()
    {

        $user = $this->user;

        if($user){

            $pdf = $this->path;

            if($pdf){

                $lien = route('user.profil', ['identifiant' => $user->identifiant]);

                $greating = ModelsRobots::greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

                $html = EmailTemplateBuilder::render('template-document', [
                    'name' => $user->getFullName(true),
                    'lien' => $lien,
                    'objet' => $this->data['document_title'],
                    'greating' => $greating,
                ]);

                return Mail::to($user->email)->send(new SendDocumentToMemberMail($user, $this->path, $this->data['document_title'], $html));

            }
        }
        elseif($this->admin_generator){

            $admin = $this->admin_generator;

            $pdf = $this->path;

            if($pdf){

                $lien = route('user.profil', ['identifiant' => $admin->identifiant]);

                $greating = ModelsRobots::greatingMessage($admin->getUserNamePrefix(true, false)) . ", ";

                $html = EmailTemplateBuilder::render('template-document', [
                    'name' => $admin->getFullName(true),
                    'lien' => $lien,
                    'objet' => $this->data['document_title'],
                    'greating' => $greating,
                ]);

                return Mail::to($admin->email)->send(new SendDocumentToMemberMail($admin, $this->path, $this->data['document_title'], $html));

            }
        }
    }
}
