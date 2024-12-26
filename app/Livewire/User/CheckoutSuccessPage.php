<?php

namespace App\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Carbon;
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

            if($order && ($order->user_id == auth_user()->id || auth_user()->isAdminAs())){

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


    public function completedOrder($order_id)
    {
        $data = ['completed' => true];
    }

    public function shippedOrder($order_id)
    {
        $now = Carbon::now();

        $data = ['payment_status' => 'shipped', 'status' => 'delivered', 'shipping_date' => $now->format('Y-m-d')];

        $order = Order::find($order_id);

        if($order) $order->update($data);
    }

    public function deleteOrder($order_id)
    {
        
    }



    public function render()
    {
        return view('livewire.user.checkout-success-page');
    }
}
