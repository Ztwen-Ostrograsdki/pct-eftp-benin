<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;

class AboutUs extends Component
{
    public function render()
    {
        $members = Member::all();

        return view('livewire.about-us', compact('members'));
    }
}
