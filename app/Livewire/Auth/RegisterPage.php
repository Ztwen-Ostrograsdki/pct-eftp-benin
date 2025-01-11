<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads, Toast;

    public $is_perso_data_insertion = true;

    public $is_graduate_data_insertion = false;

    public $is_professionnal_data_insertion = false;

    public $is_password_data_insertion = false;

    public $section = 'perso';

    public $user;




    public function mount()
    {
        if(session()->has('register-section')){

            $this->section = session('register-section');
        }

        $section = $this->section;

        if($section === 'graduate'){

            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = true;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'professionnal'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = true;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'perso'){
            $this->is_perso_data_insertion = true;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'password'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = true;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function register()
    {

        if($this->validate()){

            $names_exists = User::where('firstname', $this->firstname)->where('lastname', $this->lastname)->first();

            if(!$names_exists){

                $identifiant = ModelsRobots::makeUserIdentifySequence();
                
                if($this->profil_photo){

                    $extension = $this->profil_photo->extension();

                    $file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

                    $save = $this->profil_photo->storeAs("users/", $file_name . '.' . $extension, ['disk' => 'public']);
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
                        'identifiant' => $identifiant,
                        'auth_token' => Str::replace("/", $identifiant, Hash::make($identifiant)),
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
                        'identifiant' => $identifiant,
                        'auth_token' =>Str::replace("/", $identifiant, Hash::make($identifiant)),
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


    

    public function initGraduateDataInsertion()
    {
        
    }

    public function initProfessionnalDataInsertion()
    {
        
    }

    public function initLastDataInsertion()
    {
        //Set password and profil photo
    }



    public function clearPersoData()
    {
        $this->reset(
            'pseudo',
            'password',
            'firstname',
            'lastname' ,
            'identifiant',
            'auth_token',
            'email',
        );
    }

    public function clearGraduateData()
    {
        
    }

    public function clearProfessionnalData()
    {
        $this->reset(
            'matricule',
            'job_city' ,
            'grade' ,
            'school' ,
            'status',
            'teaching_since' ,
            'general_school' ,
            'from_general_school' ,
            'years_experiences' ,
        );
    }

    public function updated($password_confirmation)
    {
        $this->validateOnly('password');
    }

    #[On('UpdateSectionInsertion')]
    public function updateTheSection($section)
    {
        if($section === 'graduate'){

            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = true;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'professionnal'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = true;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'perso'){
            $this->is_perso_data_insertion = true;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }
        elseif($section === 'password'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = true;
        }

        $this->section = $section;

        session()->put('register-section', $section);
    }
}

