<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\NotifyUserThatOrderHasBeenApproved;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobApproveOrder implements ShouldQueue
{
    use Queueable, Batchable;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(!$this->order->approved){

            $this->order->update(['approved' => true]);

            $this->order->user->notify(new NotifyUserThatOrderHasBeenApproved($this->order));
        }
    }
}
