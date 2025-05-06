<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Lycee;
use Livewire\Attributes\On;
use Livewire\Component;

class LyceePromotionsManagerModal extends Component
{
    use Toast;

    public $promotions_id = [];

    public $selecteds = [];

    public $modal_name = "#lycee-promotions-manager-modal";

    public $counter = 2;

    public $selected_lycee;

    public function render()
    {
        $promotions = getPromotions();

        return view('livewire.master.modals.lycee-promotions-manager-modal', 
            [
                'promotions' => $promotions,
            ]
        );
    }


    public function insert()
    {
        $this->promotions_id = $this->selecteds;

        $promotions = [];

        $selecteds = $this->selecteds;
        
        foreach($selecteds as $fid){

            $promotions[] = $fid;

        }

        $lycee = $this->selected_lycee;

        $updated = $lycee->update(['promotions_id' => $promotions]);

        if($updated){

            $this->toast("Les données ont été mises à jour avec succès!", 'success');

            $this->reset();

            $this->dispatch('LyceeDataUpdatedLiveEvent');

            $this->hideModal();

        }
        else{
            $this->toast("L'insertion a échoué", 'error');
        }

        
    }

    public function pushIntoSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(!in_array($id, $selecteds)){

            $selecteds[$id] = $id;
        }

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->selecteds = $selecteds;
    }

    #[On('ManageLyceePromotions')]
    public function openModal($lycee_id = null)
    {
        $this->selected_lycee = Lycee::find($lycee_id);

        if($this->selected_lycee){

            $this->selecteds = (array)$this->selected_lycee->promotions_id;

        }
        
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
