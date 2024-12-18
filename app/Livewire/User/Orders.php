<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Mes commandes")]
class Orders extends Component
{

    use Confirm, Toast, WithPagination;

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

        $user = auth_user();

        $query = Order::query()->where('user_id', $user->id)->orderBy('updated_at', 'desc');

        if($this->sectionned && $this->sectionned !== "new"){

            $query->where('status', $this->sectionned);

        }

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        return view('livewire.user.orders', 
            [
                'order_status' => $order_status,
                'orders' => $query->paginate(2),
            ]
        );
    }

    public function deleteOrder($order_id)
    {
        
    }
}
