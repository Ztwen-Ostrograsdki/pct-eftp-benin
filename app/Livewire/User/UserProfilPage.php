<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profil Utilisateur')]
class UserProfilPage extends Component
{
    public $user;

    public function mount($id)
    {
        if($id){
            $user = User::find($id);

            if($user) $this->user = $user;

            if(!$user) return abort(404, "La page est introuvable");
        }
    }


    public function render()
    {
        return view('livewire.user.user-profil-page');
    }
}
