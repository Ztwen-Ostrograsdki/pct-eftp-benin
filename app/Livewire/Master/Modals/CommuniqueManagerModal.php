<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitCommuniqueManagerEvent;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CommuniqueManagerModal extends Component
{

    use Toast, Confirm;

    #[Validate('required|string')]
    public $title;

    #[Validate('required|string')]
    public $objet;

     #[Validate('required|string')]
    public $content;

    public $user_id;

    public $counter = 2;

    public $modal_name = "#communique-manager-modal";

    
    public function render()
    {
        return view('livewire.master.modals.communique-manager-modal');
    }


    public function insert()
    {

        $this->validate();

        $admin = auth_user();

        $communique_key = Str::random(30);

        $data = [
            'title' => $this->title,
            'objet' => $this->objet,
            'content' => $this->content,
            'user_id' => $admin->id,
            'description' => $communique_key,
        ];

        InitCommuniqueManagerEvent::dispatch($admin, $data, $communique_key);

        
    }

    #[On('ManageCommnuniqueEvent')]
    public function openModal($communique_id = null)
    {
        if($communique_id){

            
        }

        $this->dispatch('OpenModalEvent', $this->modal_name);

    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

}
