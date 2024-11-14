<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Illuminate\Support\Str;
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

    public function updatePerso()
    {

        if($this->validate()){

            $names_exists = User::where('firstname', $this->firstname)->where('lastname', $this->lastname)->where('id', '<>', $this->user->id)->first();

            if(!$names_exists){

                $user = $this->user->update([
                    'pseudo' => Str::ucwords($this->pseudo),
                    'firstname' => Str::upper($this->firstname),
                    'lastname' => Str::ucwords($this->lastname),
                ])->save();

                if($user){

                    $auth = $user->sendVerificationLinkOrKeyToUser();

                    if($auth){

                        $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";

                        $this->toast($message, 'info', 5000);

                        session()->flash('success', $message);

                        return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");
                        
                    }
                    else{

                        $this->toast( "L'incription a échoué! Veuillez réessayer!", 'error');

                    }
                    
                }
                else{

                    $message = "L'incription a échoué! Veuillez réessayer!";

                    session()->flash('error', $message);

                    $this->toast($message, 'error', 7000);

                }
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
}
