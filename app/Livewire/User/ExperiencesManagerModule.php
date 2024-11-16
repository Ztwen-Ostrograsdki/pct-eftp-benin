<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
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

    protected $rules = [
        'matricule' => 'string',
        'job_city' => 'string|required',
        'years_experiences' => 'string|required',
        'grade' => 'string',
        'school' => 'string',
        'status' => 'string|required',
        'teaching_since' => 'date|required|',
    ];


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

    public function updateUserExperiencesData()
    {
        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");

        $this->resetErrorBag();

        $this->validate();

        $data = [
            'matricule' => $this->matricule,
            'job_city' => $this->job_city,
            'grade' => $this->grade,
            'school' => $this->school,
            'status' => $this->status,
            'teaching_since' => $this->teaching_since,
            'years_experiences' => $this->years_experiences,
        ];

        $options = ['event' => 'confirmedUserExperiencesDataUpdate', 'data' => $data];

        $this->confirm("Confirmation de la mise à jour des données de " . $this->user->getFullName(true), "Cette action est irréversible", $options);

    }

    #[On('confirmedUserExperiencesDataUpdate')]
    public function onConfirmationUserExperiencesDataUpdate($data)
    {
        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");
        
        if($data){

            $user = $this->user->update($data);

            $user = true;

            if($user){

                $message = "La mise à jour est terminée.";

                $this->toast($message, 'success');

                session()->flash('success', $message);

                $this->cancelExperiencesEdition();
                
            }
            else{

                $this->toast( "La mise à jour a échoué! Veuillez réessayer!", 'error');

            }
        }

    }

}
