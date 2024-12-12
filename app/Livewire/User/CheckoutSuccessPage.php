<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Component;

class CheckoutSuccessPage extends Component
{
    public $order;


    public function mount($identifiant)
    {
        if($identifiant){

            $order = Order::where('orders.identifiant', $identifiant)->first();

            if($order && $order->user_id == auth_user()->id){

                $this->order = $order;

            }
            else{

                return abort(404, "Page introuvable!");
            }

        }
        else{

            return abort(404, "Page introuvable!");

        }

        
    }



    public function render()
    {
        return view('livewire.user.checkout-success-page');
    }
}
