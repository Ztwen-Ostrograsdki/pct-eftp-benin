<?php

namespace App\Listeners;

use App\Events\UserUnIdentifiedTryingLoginEvent;
use App\Jobs\JobNotifyAdminThatAUndentifiedUserTryingToLogin;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class NotifyAdminThatUnIdentfiedUserIsTryingToConnect
{
    
    /**
     * Handle the event.
     */
    public function handle(UserUnIdentifiedTryingLoginEvent $event): void
    {
        $batch = Bus::batch([

                new JobNotifyAdminThatAUndentifiedUserTryingToLogin($event->user),

            ])->then(function(Batch $batch) use ($event){

                UserUnIdentifiedTryingLoginEvent::dispatch($event->user);
            })
            ->catch(function(Batch $batch, Throwable $er){

                
            })

            ->finally(function(Batch $batch){


        })->name('user_blocking')->dispatch();
    }
}
