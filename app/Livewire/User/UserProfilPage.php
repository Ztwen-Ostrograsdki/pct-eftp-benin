<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Livewire\User\ExperiencesManagerModule;
use App\Livewire\User\GraduateManagerModule;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profil Utilisateur')]
class UserProfilPage extends Component
{
    protected $listeners = [
        'HideUserPersoModuleLiveEvent' => "cancelPersoEdition",
    ];

    use WithFileUploads, Toast, Confirm;

    public $user;

    public $editing_graduate = false;

    public $editing_perso = false;

    public $show_perso = false;

    public $editing_experiences = false;


    public $hidden_graduate = false;

    public $hidden_experiences = false;

    public $pseudo;
    public $birth_date;
    public $birth_city;
    public $marital_status;
    public $address;
    public $status;
    public $contacts;
    public $gender;
    public $lastname;
    public $firstname;


    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
    }


    public function startPersoEdition()
    {

        $this->editing_perso = true;

        $this->show_perso = true;

        $this->hidden_experiences = true;

        $this->hidden_graduate = true;

    }
    
    
    
    public function cancelPersoEdition()
    {
        $this->editing_perso = false;

        $this->show_perso = false;

        $this->hidden_experiences = false;

        $this->hidden_graduate = false;

        $user = $this->user;

        if($user){

            $this->birth_city = $user->birth_city ? $this->user->birth_city : 'Non renseigné';
            $this->birth_date = $user->birth_date ? $this->user->birth_date : 'Non renseigné';
            $this->address = $user->address ? $this->user->address : 'Non renseigné';
            $this->contacts = $user->contacts ? $this->user->contacts : 'Non renseigné';
            $this->gender = $user->gender ? $this->user->gender : 'Non renseigné';
            $this->pseudo = $user->pseudo ? $this->user->pseudo : 'Non renseigné';
            $this->status = $user->status ? $this->user->status : 'Non renseigné';
            $this->firstname = $user->firstname ? $this->user->firstname : 'Non renseigné';
            $this->lastname = $user->lastname ? $this->user->lastname : 'Non renseigné';
        }

    }

    public function render()
    {
        return view('livewire.user.user-profil-page');
    }

    public function confirmedData()
    {
        $options = ['event' => 'confirmedEvent'];

        $this->confirm("Suppression de données", "Cette action est irréversible", $options);
    }


    #[On('confirmedEvent')]
    public function onConfirmationData()
    {
        $this->toast("Precessus confirmé", "success");
    }


}
