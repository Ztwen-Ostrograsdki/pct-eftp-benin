<?php

namespace App\Jobs;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobOrderManager implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;

        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->doJob();
    }


    public function doJob()
    {
        DB::transaction(function () {
            if($this->data){

                $order_data = $this->data['order'];

                $items = $this->data['items'];

                $address_init_data = $this->data['address'];

                $address_images = $this->data['address_images'];

                //CREATING THE ORDER

                $order = Order::create($order_data);

                if($order){

                    //CREATING THE ORDER ADDRESS

                    $address_init_data['order_id'] = $order->id;

                    $address = Address::create($address_init_data);

                    if($address){

                        if($address_images){

                            $to_db_images = [];

                            foreach($address_images as $file_name =>  $image){
                
                                $extension = $image->extension();

                                $db_name = 'address/' . $file_name . '.' . $extension;
                
                                $image->storeAs('public/' . $db_name);
                
                                $to_db_images[] = $db_name;
                
                            }

                            $address->update(['images' => $to_db_images]);
                        }

                        foreach($items as $book_id => $item){

                            //CREATING EACH ORDER_ITEM

                            $order_item_data = [
                                'order_id' => $order->id,
                                'book_id' => $book_id,
                                'quantity' => $item['quantity'],
                                'unit_amount' => $item['unit_amount'],
                                'total_amount' => $item['total_amount'],
                            ];

                            $order_item = OrderItem::create($order_item_data);

                            if($order_item){

                                $order_item_data = [];
                            }
                        }

                        $order->update(['status' => 'processing']);
    
                    }
                }
            }
        });

    }
}
