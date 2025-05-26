<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restorer:compte {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Restoration de compte utilisateur";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
