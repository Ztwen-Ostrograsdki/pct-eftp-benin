<?php

namespace App\Livewire\Master;

use App\Models\Communique;
use Livewire\Component;

class CommuniquesDispatchedToAll extends Component
{
    public function render()
    {
        $communiques = Communique::where('hidden', false)->get();
        
        return view('livewire.master.communiques-dispatched-to-all', compact('communiques'));
    }
}
