<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitCommuniqueManagerEvent;
use App\Models\Communique;
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
    
    #[Validate('required|string')]
    public $from;

    public $user_id;

    public $communique;

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

        $string = $this->title . '-' . $this->objet;

        $slug = Str::lower(Str::slug($string));

        $data = [
            'title' => $this->title,
            'objet' => $this->objet,
            'content' => $this->content,
            'from' => $this->from,
            'slug' => $slug,
            'user_id' => $admin->id,
            'description' => $communique_key,
        ];

        InitCommuniqueManagerEvent::dispatch($admin, $data, $communique_key, $this->communique);

        $this->hideModal();

        $this->reset();
        
    }

    #[On('ManageCommnuniqueEvent')]
    public function openModal($communique_id = null)
    {
        if($communique_id){

            $communique = Communique::find($communique_id);

            if($communique){

                $this->communique = $communique;

                $this->content = $communique->content;

                $this->objet = $communique->objet;

                $this->title = $communique->title;

                $this->from = $communique->from;

            }

            
        }

        $this->dispatch('OpenModalEvent', $this->modal_name);

    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

}
