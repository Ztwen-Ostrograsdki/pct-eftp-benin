<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewLawModal extends Component
{
    public function render()
    {
        return view('livewire.master.modals.new-law-modal');
    }
    use Toast;

    #[Validate('required|string|unique:laws')]
    public $name;

    public $description;

    public $editing = null;

    public $modal_name = "#law-manager-modal";

    public $counter = 2;


    public function insert()
    {

    }

    #[On('OpenLawManagerModal')]
    public function openModal($law_id = null)
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

}
