<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Component;

class ExperiencesManagerModule extends Component
{
    use Toast, Confirm;

    protected $listeners = [
        
    ];

    public $user;

    public $experiences_title = "Profession et expériences dans le métier";
    public $editing_experiences = false;



    public $hidden_experiences = false;

    public $job_city;
    public $school;
    public $teaching_since;
    public $years_experiences;
    public $grade;
    public $matricule;
    public $status;


    public function mount()
    {

        if($this->user){

            $user = $this->user;

            $this->matricule = $user->matricule ? $this->user->matricule : 'Non renseigné';
            $this->status = $user->status ? $this->user->status : 'Non renseigné';
            $this->job_city = $user->job_city ? $this->user->job_city : 'Non renseigné';
            $this->years_experiences = $user->years_experiences ? $this->user->years_experiences : 'Non renseigné';
            $this->teaching_since = $user->teaching_since ? $this->user->teaching_since : 'Non renseigné';
            $this->grade = $user->grade ? $this->user->grade : 'Non renseigné';
            $this->school = $user->school ? $this->user->school : 'Non renseigné';
            
        }

    }

    public function startExperiencesEdition()
    {
        $this->editing_experiences = true;


    }
    
    public function cancelExperiencesEdition()
    {
        $this->editing_experiences = false;

        $user = $this->user;

        if($user){

            $this->matricule = $user->matricule ? $this->user->matricule : 'Non renseigné';
            $this->status = $user->status ? $this->user->status : 'Non renseigné';
            $this->job_city = $user->job_city ? $this->user->job_city : 'Non renseigné';
            $this->years_experiences = $user->years_experiences ? $this->user->years_experiences : 'Non renseigné';
            $this->teaching_since = $user->teaching_since ? $this->user->teaching_since : 'Non renseigné';
            $this->grade = $user->grade ? $this->user->grade : 'Non renseigné';
            $this->school = $user->school ? $this->user->school : 'Non renseigné';
        }
    }

    

    public function toggleExperiencesSection()
    {
        $this->hidden_experiences = !$this->hidden_experiences;

    }


    public function render()
    {
        return view('livewire.user.experiences-manager-module');
    }
}
