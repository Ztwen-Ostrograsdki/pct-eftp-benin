<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use Confirm, Toast, WithPagination;

    public $sectionned = 'new';

    public $search = '';

    public $counter = 1;

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

        $query = Order::query()->orderBy('updated_at', 'desc');

        if($this->sectionned && $this->sectionned !== "new"){

            $query->where('status', $this->sectionned);

        }

        if($this->sectionned && $this->sectionned == 'approved'){

            $query->where('approved', true);
        }

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        return view('livewire.master.orders-list', 
            [
                'order_status' => $order_status,
                'orders' => $query->paginate(2),
            ]
        );
    }

    #[On('LiveNewOrderHasBeenCreatedSuccessfullyEvent')]
    public function newOrderCompleted($order)
    {
        $message = "Une nouvelle commande a été reçue";

        $this->toast($message, 'success');

        to_flash('new_order', $message);

        $this->counter = rand(12, 1999);

    }

    #[On('LiveTheOrderApprovedSuccessfullyEvent')]
    public function orderApproved($order_identifiant)
    {
        $this->toast("Votre commande N° ". $order_identifiant. " a été approuvée avec succès. Vous pouvez procéder au payement", 'success');
    
        $this->counter = rand(12, 300);
    }
    
    #[On('LiveTheOrderApprovedSuccessfullyEventForAdmin')]
    public function orderApprovedForAdmins($order_identifiant)
    {
        $this->toast("La commande N° ". $order_identifiant. " a été approuvée avec succès.", 'success');
        
        $this->counter = rand(12, 300);
    }
    
}
