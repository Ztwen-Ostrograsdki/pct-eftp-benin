<?php

namespace App\Livewire\Master;

use App\Models\Communique;
use Livewire\Attributes\On;
use Livewire\Component;

class CommuniquesDispatchedToAll extends Component
{

    public $counter = 1;

    public function render()
    {
        $communiques = Communique::whereYear('created_at', now()->year)->where('hidden', false)->latest()->get();
        
        return view('livewire.master.communiques-dispatched-to-all', compact('communiques'));
    }


    #[On('LiveUpdateCommuniquesListEvent')]
    public function reloadDataList()
    {
        $this->counter = getRand();
    }
}
