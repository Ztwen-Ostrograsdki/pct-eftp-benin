<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Carbon;

class ObserveOrder
{
    /**
     * Handle the order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the order "updated" event.
     */
    public function updated(Order $order): void
    {
        if($order->status == 'delivered' && !$order->shipping_date){
            
            $now = Carbon::now();

            $order->updated(['shipping_date' => $now]);
        }
    }

    /**
     * Handle the order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
