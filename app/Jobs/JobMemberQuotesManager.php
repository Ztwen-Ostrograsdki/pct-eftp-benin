<?php

namespace App\Jobs;

use App\Models\Quote;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class JobMemberQuotesManager implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public string $content,
        public ?Quote $quote = null
    )
    {
        $this->user = $user;

        $this->quote = $quote;

        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->quote){

            $this->quote->update(['content' => $this->content]);

        }
        else{

            $max = env('APP_MEMBER_MAX_QUOTES');

            if(count($this->user->quotes) >= $max){

                Notification::sendNow([$this->user], new RealTimeNotificationGetToUser("L'insertion de la citation a échoué vous ne pouvez pas publier plus de {$max} citations!"));

                $this->fail();

            }
            else{
                
                Quote::create(['content' => $this->content, 'user_id' => $this->user->id]);
            }


            
        }
        
    }
}
