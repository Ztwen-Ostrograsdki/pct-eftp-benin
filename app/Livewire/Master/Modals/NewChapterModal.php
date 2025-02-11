<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewChapterModal extends Component
{
    
    use Toast;

    #[Validate('required|string')]
    public $chapter;

    public $description;

    #[Validate('required')]
    public $law_id;

    public $editing = null;

    public $modal_name = "#chapter-manager-modal";

    public $counter = 2;

    public function render()
    {
        return view('livewire.master.modals.new-chapter-modal');
    }

    public function insert()
    {
        
    }

    #[On('AddNewChapterEvent')]
    public function openModal($article_id = null)
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
