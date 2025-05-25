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
        $communiques = Communique::where('hidden', false)->get();
        
        return view('livewire.master.communiques-dispatched-to-all', compact('communiques'));
    }

    #[On('UpdatedCommuniquesList')]
    public function reloadData()
    {
        $this->counter = getRand();
    }

    #[On('LiveUpdateCommuniquesListEvent')]
    public function reloadDataList()
    {
        $this->counter = getRand();
    }
}
