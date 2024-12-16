<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Commande validée et traitée avec succès")]
class CheckoutSuccessPage extends Component
{
    public $order;

    public $address;


    public function mount($identifiant)
    {
        if($identifiant){

            $order = Order::where('orders.identifiant', $identifiant)->first();

            if($order && $order->user_id == auth_user()->id){

                $this->order = $order;

                $this->address = $order->address;

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
