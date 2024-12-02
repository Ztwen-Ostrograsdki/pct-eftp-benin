<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Boutique")]
class ShoppingHome extends Component
{
    public function render()
    {
        return view('livewire.shop.shopping-home');
    }
}
