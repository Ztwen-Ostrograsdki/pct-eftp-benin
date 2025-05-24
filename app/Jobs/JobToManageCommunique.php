<?php

namespace App\Jobs;

use App\Models\Communique;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class JobToManageCommunique implements ShouldQueue
{
    use Queueable, Batchable;

    public $communique;

    public $pdf_path;

    public $tries = 3;

    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin_generator,
        public $data
    )
    {
        $this->admin_generator = $admin_generator;

        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = $this->admin_generator;

        $data = $this->data;

        if($data){

            $communique = self::insertIntoDB($data);

            if($communique){

                $this->communique = $communique;

                self::generatePdf($communique);


            }


        }
    }


    protected function generatePdf($communique)
    {
        if($communique){

            $admin = $this->admin_generator;

            // Configure la locale française
            Carbon::setLocale('fr');

            // Crée la date actuelle avec timezone (exemple Africa/Abidjan)
            $now = Carbon::now('Africa/Abidjan');

            $plateforme_name = env('APP_NAME');

            
            $formattedDate = 'Générée et imprimée sur la plateforme ' . $plateforme_name . ' le ' 
                . $now->isoFormat('dddd D MMMM YYYY')  // Ex: lundi 25 mai 2025
                . ' à ' 
                . $now->isoFormat('HH\H mm\min ss\s'); // Ex: 10H 15min 24s

            $header_title = " COMMUNIQUE " . $communique->title . "Généré et imprimé sur la plateforme " . $plateforme_name;

            $headerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:gray;">'
                . $header_title
                . '</div>';

            $footerHtml = '<div style="font-size:10px; width:100%; text-align:center; color:black;">'
            . $formattedDate
            . ' | Page <span class="pageNumber"></span> / <span class="totalPages"></span>'
            . '</div>';


            $data = [
                'communique' => $communique,

            ];

            $html = View::make('pdftemplates.communique', $data)->render();

            $root = storage_path("app/public/communiques");

            if(!File::isDirectory($root)){

                $directory_make = File::makeDirectory($root, 0777, true, true);

            }

            if(!File::isDirectory($root) && !$directory_make){

                $this->fail();

            }

            $created_at = Carbon::parse($communique->created_at)->isoFormat('dddd D MMMM YYYY'); 

            $path = "communique-" . $communique->id . "-du-" . Str::slug($created_at) . '.pdf';

            ini_set("max_execution_time", 300);
            
            $pdf_path = storage_path("app/public/communiques/". $path);

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
                ->save($pdf_path);

            $done = File::exists($pdf_path);

            if($done){

                $communique->update(['pdf_path' => $pdf_path]);

            }

        }
    }

    protected function insertIntoDB($data)
    {
        return Communique::create($data);
    }
}
