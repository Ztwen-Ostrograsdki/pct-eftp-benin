<?php

namespace App\Livewire;

use Livewire\Component;

class FedapayCheckoutPage extends Component
{
    public $token;

    
    public function render()
    {
        return view('livewire.fedapay-checkout-page');
    }

    public function mount($token)
    {
        $this->token = $token;
    }


    public function checkout()
    {

    }
}
