<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Lycee;
use Livewire\Attributes\On;
use Livewire\Component;

class LyceeFiliarsManagerModal extends Component
{
    use Toast;

    public $filiars_id = [];

    public $selecteds = [];

    public $modal_name = "#lycee-filiars-manager-modal";

    public $counter = 2;

    public $selected_lycee;

    public function render()
    {
        $filiars = getFiliars();

        return view('livewire.master.modals.lycee-filiars-manager-modal', 
            [
                'filiars' => $filiars,
            ]
        );
    }


    public function insert()
    {
        $this->filiars_id = $this->selecteds;

        $filiars = [];

        $selecteds = $this->selecteds;
        
        foreach($selecteds as $fid){

            $filiars[] = $fid;

        }

        $lycee = $this->selected_lycee;

        $updated = $lycee->update(['filiars_id' => $filiars]);

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

        $this->resetErrorBag();

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($id)
    {
        $tables = [];

        $this->resetErrorBag();

        $selecteds = $this->selecteds;

        if(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->selecteds = $selecteds;
    }

    #[On('ManageLyceeFiliars')]
    public function openModal($lycee_id = null)
    {
        $this->selected_lycee = Lycee::find($lycee_id);

        if($this->selected_lycee){

            $this->selecteds = (array)$this->selected_lycee->filiars_id;

        }
        
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
