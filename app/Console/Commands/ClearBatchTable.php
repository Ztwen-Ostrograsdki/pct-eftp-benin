<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClearBatchTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:vider {days?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vider la table batch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int)$this->argument('days') ? (int)$this->argument('days') : 7;

        $delay = Carbon::now()->subDays($days);

        $delay =  Carbon::parse($delay)->timestamp;

        $this->alert("Rafraissement des données enregistrées dans la table Batch depuis {$days} jours en cours...");

        DB::table('job_batches')->where('created_at', '<', $delay)->delete();

        $this->info("Les données enregistrées dans la table Batch depuis {$days} jours ont été rafraichies");
    }
}
