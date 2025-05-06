<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Models\Lycee;
use Livewire\Attributes\On;
use Livewire\Component;

class LyceesListingPage extends Component
{
    use Toast, Confirm;

    public $counter = 6;

    public $selected_lycee_id = null;

    public $selected_lycee = null;

    public $selected_department = null;

    public function render()
    {

        $departments = RobotsBeninHelpers::getDepartments();

        $selected_lycee = null;

        $filiars = [];

        $promotions = [];

        if(session()->has('selected_lycee_profil')){

            $this->selected_lycee_id = session('selected_lycee_profil');

            $selected_lycee = Lycee::find($this->selected_lycee_id);
            
        }

        if($this->selected_lycee_id){

            $selected_lycee = Lycee::find($this->selected_lycee_id);

            $filiars = $selected_lycee->getFiliars();

            $promotions = $selected_lycee->getPromotions();

            $this->selected_lycee = $selected_lycee;
        }

        $lycees = [];

        if(session()->has('selected_department_lycee_profil')){

            $this->selected_department = session('selected_department_lycee_profil');

        }

        if($this->selected_department){

            $lycees = Lycee::where('lycees.department', $this->selected_department)->get();

        }
        else{

            $lycees = Lycee::all();

        }
        
        return view('livewire.master.lycees-listing-page', [
            'lycees' => $lycees,
            'departments' => $departments,
            'filiars' => $filiars,
            'promotions' => $promotions,
            
        ]);
    }

    public function manageLyceeFiliars()
    {
        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceeFiliars', $lycee_id);
    }

    public function manageLyceeData()
    {
        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceeData', $lycee_id);
    }


    public function addNewLycee()
    {
        $this->dispatch('AddNewLyceeEvent');
    }

    public function manageLyceePromotions()
    {
        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceePromotions', $lycee_id);
    }


    public function deleteLycee()
    {
        if($this->selected_lycee){

            

        }
        
    }


    public function updatedSelectedDepartment($department)
    {

        session()->put('selected_department_lycee_profil', $department);

        if($this->selected_lycee){

            if($this->selected_lycee->department !== $department){

                session()->forget('selected_lycee_profil');

                $this->reset('selected_lycee', 'selected_lycee_id');

            }

        }
        else{

            $this->reset('selected_lycee', 'selected_lycee_id');

            session()->forget('selected_lycee_profil');
        }

    }


    public function updatedSelectedLyceeId($selected_lycee_id)
    {
        if($selected_lycee_id){

            session()->put('selected_lycee_profil', $selected_lycee_id);
        }
        else{

            session()->forget('selected_lycee_profil');
        }
    }


    #[On('LiveNewLyceeCreatedSuccessfullyEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
    
    #[On('LyceeDataUpdatedLiveEvent')]
    public function reloadLyceeData($data = null)
    {
        $this->counter = getRand();
    }
}
