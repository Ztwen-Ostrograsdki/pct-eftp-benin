<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class HeroSection extends Component
{
    public $counter = 1;

    
    public function render()
    {
        $members = Member::all();
        
        return view('livewire.hero-section', compact('members'));
    }


    #[On('LiveMemberQuotesUpdatedEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
}
