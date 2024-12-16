<?php

namespace App\Livewire\Master;

use Livewire\Component;

class OrderProfil extends Component
{
    public $order;

    public $address;

    public function render()
    {
        $order = $this->order;

        if($order){

            $this->address = $order->address;

        }

        return view('livewire.master.order-profil');
    }
}
