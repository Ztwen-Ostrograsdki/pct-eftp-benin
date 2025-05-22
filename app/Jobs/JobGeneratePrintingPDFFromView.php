<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
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
        public ?User $user = null


    )
    {
        $this->user = $user;

        $this->path = $path;

        $this->view_path = $view_path;

        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
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

        $done = response()->download($pdfPath);
    }
}
