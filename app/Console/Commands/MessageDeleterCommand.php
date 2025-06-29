<?php

namespace App\Console\Commands;

use App\Events\MessageSent;
use App\Models\ForumChat;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MessageDeleterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:message-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suppression des messages du jour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ForumChat::whereDate('created_at', Carbon::today())->delete();

    }
}
