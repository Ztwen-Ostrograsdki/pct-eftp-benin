<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mes commandes")]
class Orders extends Component
{

    use Confirm, Toast;

    public $sectionned = 'new';

    public $search = '';


    public function mount($identifiant)
    {
        if($identifiant){

            if(auth_user()->identifiant !== $identifiant) return abort(404, "Page introuvable!");

        }
        else{

            return abort(404, "Page introuvable!");
        }

        
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSectionned($sectionned)
    {
        $this->sectionned = $sectionned;
    }



    public function render()
    {

        $order_status = config('app.order_status');

        $orders = auth_user()->orders;

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        return view('livewire.user.orders', 
            [
                'order_status' => $order_status,
                'orders' => $orders,
            ]
        );
    }
}
