<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
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
            ->displayHeaderFooter() // Active l'affichage du header/footer
            ->footerHtml('
                <div style="font-size:10px; width:100%; text-align:center; color:gray;">
                    © MonApp 2025 — Page <span class="pageNumber"></span> / <span class="totalPages"></span>
                </div>
                ')
            ->save($pdfPath);

        $done = response()->download($pdfPath);
    }
}
