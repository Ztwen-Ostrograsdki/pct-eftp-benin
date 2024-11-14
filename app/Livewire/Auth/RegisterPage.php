<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads, Toast;

    #[Validate('required|email|unique:users|min:3|max:255')]
    public $email;

    #[Validate('required|string|min:2')]
    public $lastname;

    #[Validate('required|string|min:2')]
    public $firstname;

    #[Validate('required|string|confirmed|min:5')]
    public $password;
    
    #[Validate('nullable|image|mimes:jpeg,png,jpg|max:2400')]
    public $profil_photo;

    public $password_confirmation;

    public $pseudo;

    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function register()
    {

        if($this->validate()){

            $names_exists = User::where('firstname', $this->firstname)->where('lastname', $this->lastname)->first();

            if(!$names_exists){
                
                if($this->profil_photo){

                    $extension = $this->profil_photo->extension();

                    $file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

                    $this->profil_photo->storeAs('public/users/', $file_name . '.' . $extension);
                }

                if($this->firstname && $this->lastname){

                    $this->pseudo = Str::substr($this->firstname, 0, 3) . ' ' . Str::substr($this->lastname, 0, 3) . '' . rand(1000, 99999);
                }

                if($this->profil_photo){
                    $user = User::create([
                        'pseudo' => Str::ucwords($this->pseudo),
                        'password' => Hash::make($this->password),
                        'firstname' => Str::upper($this->firstname),
                        'lastname' => Str::ucwords($this->lastname),
                        'email' => $this->email,
                        'profil_photo' => 'users/' . $file_name . '.' . $extension,
                    ]);
                }
                else{
                    $user = User::create([
                        'pseudo' => Str::ucwords($this->pseudo),
                        'password' => Hash::make($this->password),
                        'firstname' => Str::upper($this->firstname),
                        'lastname' => Str::ucwords($this->lastname),
                        'email' => $this->email,
                    ]);
                }

                if($user){

                    $auth = $user->sendVerificationLinkOrKeyToUser();

                    if($auth){

                        $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";

                        $this->toast($message, 'info', 5000);

                        session()->flash('success', $message);

                        return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");
                        
                    }
                    else{

                        $user->delete();

                        if($this->profil_photo){
                        
                            Storage::delete($file_name . '.' . $extension);
                        }

                        redirect(route('register'))->with('error', "L'incription a échoué! Veuillez réessayer!");

                    }
                    
                }
                else{

                    $message = "L'incription a échoué! Veuillez réessayer!";

                    session()->flash('error', $message);

                    $this->toast($message, 'error', 7000);

                    if($this->profil_photo){
                        
                        Storage::delete($file_name . '.' . $extension);
                    }

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

    public function updated($password_confirmation)
    {
        $this->validateOnly('password');
    }
}

