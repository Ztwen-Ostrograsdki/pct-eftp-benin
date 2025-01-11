<?php

namespace App\Livewire\Master\Modals;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class OpenUserProfilPhotoViewComponent extends Component
{
    public $user;

    public $user_id;

    public $modal_name = "#user-profil-photo-viewer";

    public function render()
    {
        return view('livewire.master.modals.open-user-profil-photo-view-component');
    }



    #[On('OpenUserProfilPhotoEvent')]
    public function openModal($user_id)
    {
        if($user_id){

            $user = User::find($user_id);

            if($user){

                $this->user = $user;
            }
        }

        $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
