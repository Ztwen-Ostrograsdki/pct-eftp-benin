<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use Livewire\Component;

class Dashboard extends Component
{
    public $counter = 1;

    use ListenToEchoEventsTrait;


    public function render()
    {
        return view('livewire.master.dashboard');
    }
}
