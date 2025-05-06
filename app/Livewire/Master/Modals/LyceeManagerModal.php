<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitNewLyceeDataInsertionEvent;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Models\Lycee;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LyceeManagerModal extends Component
{
    use Toast;

    #[Validate('required|string')]
    public $name;

    #[Validate('required|string')]
    public $department;

    #[Validate('required|string')]
    public $city;

    public $description;

    public $censeur;

    public $provisor;

    #[Validate('boolean|required')]
    public $is_public;

    public $department_id;

    public $rank;

    public $editing = null;

    public $modal_name = "#lycee-manager-modal";

    public $counter = 2;

    public $editing_lycee = null;

    public function render()
    {
        $cities = [];

        if($this->department_id){

            $cities = RobotsBeninHelpers::getCities($this->department_id);

        }

        $departments = RobotsBeninHelpers::getDepartments();

        return view('livewire.master.modals.lycee-manager-modal', 
            [
                'departments' => $departments,
                'cities' => $cities,
            ]
        );
    }


    public function insert()
    {
        $this->resetErrorBag();

        $this->validate();


        $data = [
            'name' => $this->name,
            'provisor' => $this->provisor,
            'censeur' => $this->censeur,
            'is_public' => $this->is_public,
            'department' => $this->department,
            'city' => $this->city,
            'rank' => $this->rank,
            'description' => $this->description,

        ];

        $dispatched = InitNewLyceeDataInsertionEvent::dispatch($data, $this->editing_lycee->id);

        if($dispatched) $this->hideModal();
        
    }

    public function updatedDepartment($department)
    {
        $this->reset('department_id');

        if($department && $department !== 'non defini'){

            $departments = RobotsBeninHelpers::getDepartments();

            if(array_key_exists($department, array_flip($departments))){

                $this->department_id = (int)array_keys($departments, $department)[0];
            }

        }
    }

    #[On('AddNewLyceeEvent')]
    public function openModal()
    {
        $this->reset();


        $this->dispatch('OpenModalEvent', $this->modal_name);
    } 
    
    
    #[On('ManageLyceeData')]
    public function openModalForEdit($lycee_id = null)
    {
        if(!$lycee_id){

            $lycee_id = session('selected_lycee_id');
        }

        if($lycee_id){

            $lycee = Lycee::find($lycee_id);

            if($lycee){

                $this->editing = true;

                $this->name = $lycee->name;

                $this->provisor = $lycee->provisor;

                $this->censeur = $lycee->censeur;

                $this->is_public = $lycee->is_public;

                $this->department = $lycee->department;

                $this->city = $lycee->city;

                $this->rank = $lycee->rank;

                $this->description = $lycee->description;

                $this->editing_lycee = $lycee;

                $this->dispatch('OpenModalEvent', $this->modal_name);


            }


        }
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
