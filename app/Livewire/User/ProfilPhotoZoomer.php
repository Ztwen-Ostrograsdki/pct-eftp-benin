<?php

namespace App\Livewire\User;

use Livewire\Component;

class ProfilPhotoZoomer extends Component
{
    public $user;
    
    public function render()
    {
        return view('livewire.user.profil-photo-zoomer');
    }
}
