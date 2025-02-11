<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewArticleModal extends Component
{
    use Toast;

    #[Validate('required|string')]
    public $name;

    #[Validate('required|string')]
    public $content;

    #[Validate('required')]
    public $law_id;

    #[Validate('required')]
    public $chapter_id;

    public $editing = null;

    public $modal_name = "#article-manager-modal";

    public $counter = 2;

    public function render()
    {
        return view('livewire.master.modals.new-article-modal');
    }


    public function insert()
    {

        
    }

    #[On('AddNewArticleEvent')]
    public function openModal($article_id = null)
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
