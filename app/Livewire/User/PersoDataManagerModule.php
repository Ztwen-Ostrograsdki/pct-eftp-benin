<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PersoDataManagerModule extends Component
{
    use WithFileUploads, Toast, Confirm;

    public $editing_perso = false;

    public $show_perso = false;

    public $user;
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

    public function mount()
    {
        if($this->user){

            $user = $this->user;

            $this->status = $user->status ? $this->user->status : 'Non renseigné';
            $this->birth_city = $user->birth_city ? $this->user->birth_city : 'Non renseigné';
            $this->birth_date = $user->birth_date ? $this->user->birth_date : 'Non renseigné';
            $this->address = $user->address ? $this->user->address : 'Non renseigné';
            $this->contacts = $user->contacts ? $this->user->contacts : 'Non renseigné';
            $this->gender = $user->gender ? $this->user->gender : 'Non renseigné';
            $this->pseudo = $user->pseudo ? $this->user->pseudo : 'Non renseigné';
            $this->status = $user->status ? $this->user->status : 'Non renseigné';
            $this->firstname = $user->firstname ? $this->user->firstname : 'Non renseigné';
            $this->lastname = $user->lastname ? $this->user->lastname : 'Non renseigné';
            $this->marital_status = $user->marital_status ? $this->user->marital_status : 'Non renseigné';

        }
    }

    
    public function render()
    {
        return view('livewire.user.perso-data-manager-module');
    }

    public function cancelPersoEdition()
    {
        $this->show_perso = false;

        $this->dispatch('HideUserPersoModuleLiveEvent');

        $this->show_perso = false;

        $this->editing_perso = false;
    }

    public function updateUserPersoData()
    {
        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");

        $this->resetErrorBag();

        if($this->user && $this->pseudo && $this->firstname && $this->lastname){

            $rules = [
                'pseudo' => 'string|required',
                'firstname' => 'string|required',
                'lastname' => 'string|required',
                'gender' => 'string|required',
                'address' => 'string|required',
                'status' => 'string|required',
                'contacts' => 'string|required',
                'marital_status' => 'string|required',
                'birth_date' => 'date|required|',
                'birth_city' => 'string|required|',
            ];

            $data = [
                'pseudo' => Str::ucwords($this->pseudo),
                'firstname' => Str::upper($this->firstname),
                'lastname' => Str::ucwords($this->lastname),
                'contacts' => $this->contacts,
                'address' => Str::ucwords($this->address),
                'gender' => Str::ucwords($this->gender),
                'status' => Str::upper($this->status),
                'marital_status' => Str::ucwords($this->marital_status),
                'birth_date' => $this->birth_date,
                'birth_city' => Str::ucfirst($this->birth_city),
            ];
    

            $validated = $this->validate($rules);

            $names_exists = User::where('firstname', $this->firstname)->where('lastname', $this->lastname)->where('id', '<>', $this->user->id)->first();

            if(!$names_exists){

                $options = ['event' => 'confirmedUserUpdate', 'data' => $data];

                $this->confirm("Confirmation de la mise à jour des données de " . $this->user->getFullName(true), "Cette action est irréversible", $options);
               
            }
            else{

                $message = "Un utilisateur est déjà inscrit sous ces données!";

                $this->addError('firstname', $message);

                $this->addError('lastname', $message);

                session()->flash('error', $message);

                $this->toast($message, 'error', 7000);
            }
        }
        else{

            $message = "Le formulaire est incorrecte!";

            session()->flash('error', $message);

            $this->toast($message, 'error', 7000);
            
        }

    }

    #[On('confirmedUserUpdate')]
    public function onConfirmationUserUpdate($data)
    {

        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");
        
        if($data){

            $user = $this->user->update($data);

            if($user){

                $message = "La mise à jour est terminée.";

                $this->toast($message, 'success');

                session()->flash('success', $message);

                $this->cancelPersoEdition();
                
            }
            else{

                $this->toast( "La mise à jour a échoué! Veuillez réessayer!", 'error');

            }
        }

    }


}
