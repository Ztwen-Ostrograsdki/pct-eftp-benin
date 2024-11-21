<?php

namespace App\Listeners;

use App\Events\BlockUserEvent;
use App\Events\LogoutUserEvent;
use App\Events\UserHasBeenBlockedSuccessfullyEvent;
use App\Jobs\JobBlockUser;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class BlockUserListener
{
    

    /**
     * Handle the event.
     */
    public function handle(BlockUserEvent $event): void
    {
        $batch = Bus::batch([

            new JobBlockUser($event->user),

            ])->then(function(Batch $batch) use ($event){

                UserHasBeenBlockedSuccessfullyEvent::dispatch($event->user);

                LogoutUserEvent::dispatch($event->user);

            })
            ->catch(function(Batch $batch, Throwable $er){

                
            })

            ->finally(function(Batch $batch){


        })->name('user_blocking')->dispatch();
    }
}
