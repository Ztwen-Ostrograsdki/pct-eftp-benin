<?php

namespace App\Livewire\Master\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class ManageRoleUsersModal extends Component
{
    public $modal_name = "#role-users-manager-modal";

    public $counter = 2;

    public function render()
    {
        return view('livewire.master.modals.manage-role-users-modal');
    }

    #[On('ManageRoleUsersEvent')]
    public function openModal($role_id = null)
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
