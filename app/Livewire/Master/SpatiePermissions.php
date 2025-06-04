<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class SpatiePermissions extends Component
{
    public $counter = 2;

    use ListenToEchoEventsTrait;

    public function render()
    {
        return view('livewire.master.spatie-permissions');
    }



    
}
