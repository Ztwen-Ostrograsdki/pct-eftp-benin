<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class HeroSection extends Component
{
    public $counter = 1;

    
    public function render()
    {
        return view('livewire.hero-section');
    }


    #[On('LiveMemberQuotesUpdatedEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
}
