<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Helpers\Tools\ModelsRobots;
use App\Mail\SendDocumentToMemberMail;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class JobToGenerateAndSendDocumentToMember implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    public $timeout = 300;

    public $document_path;

    public function __construct(
        

    )
    {
        
    }

    public function handle()
    {

       
        
    }

    protected function documentBuilder()
    {
        
    }

    
}
