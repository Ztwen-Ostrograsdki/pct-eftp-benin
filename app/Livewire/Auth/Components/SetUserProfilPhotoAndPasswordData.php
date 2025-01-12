<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\SubscriptionManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SetUserProfilPhotoAndPasswordData extends Component
{
    use WithFileUploads, Toast;

    public $password;
    
    public $profil_photo;

    public $password_confirmation;

    public $pseudo;

    public $email;

    public $file_name;

    public $extension;

    public $photo_path;

    protected $rules = [
        'email' => 'required|email|unique:users|min:3|max:255',
        'password' => 'string|required|min:8|confirmed:password',
        'password_confirmation' => 'string|required',
        'profil_photo' => 'required|image|mimes:jpeg,png,jpg|max:4000',
    ];

    
    
    public function render()
    {
        self::initializator();

        return view('livewire.auth.components.set-user-profil-photo-and-password-data');
    }


    public function validatePasswordAndProfil()
    {
        
        if(!$this->profil_photo){

            if($this->photo_path){

                $this->validate([
                    'email' => 'required|email|unique:users|min:3|max:255',
                    'password' => 'string|required|min:8|confirmed:password',
                    'password_confirmation' => 'string|required',
                ]);

                $data = [
                    'email' => $this->email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                    'photo_path' => $this->photo_path,
                ];
    
                SubscriptionManager::putEmailDataIntoSession($data); 

                session()->put('email_data_is_ok', true);
    
                $this->dispatch("UpdateSectionInsertion", 'confirmed');

            }
            else{

                $this->validate();

                $this->extension = $this->profil_photo->extension();

                $this->file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

                $save = $this->profil_photo->storeAs("users/", $this->file_name . '.' . $this->extension, ['disk' => 'public']);

                $this->photo_path =  'users/' . $this->file_name . '.' . $this->extension;

                $data = [
                    'email' => $this->email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                    'photo_path' => $this->photo_path,
                ];

                SubscriptionManager::putEmailDataIntoSession($data); 

                session()->put('email_data_is_ok', true);

                $this->dispatch("UpdateSectionInsertion", 'confirmed');

            }


        }
        else{

            if($this->photo_path){
            
                $path = str_replace("users/", '', $this->photo_path);
    
                self::deletePhotoFromStorage($path);
            }

            $this->validate();

            $this->extension = $this->profil_photo->extension();

            $this->file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

            $save = $this->profil_photo->storeAs("users/", $this->file_name . '.' . $this->extension, ['disk' => 'public']);

            $this->photo_path =  'users/' . $this->file_name . '.' . $this->extension;

            $data = [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'photo_path' => $this->photo_path,
            ];

            SubscriptionManager::putEmailDataIntoSession($data); 

            session()->put('email_data_is_ok', true);

            $this->dispatch("UpdateSectionInsertion", 'confirmed');
        }

        
    }

    public function clearEmailData()
    {
        SubscriptionManager::clearDataFromSession('emailData');

        if($this->photo_path){

            $path = $this->photo_path;

            self::deletePhotoFromStorage($path);
            
            self::deletePhotoFromStorage();
        }

        $this->reset();
    }


    public function deletePhotoFromStorage($path = null)
    {

        $profil_photo = $this->photo_path;

        $path = storage_path().'/app/public/' . $profil_photo;

        return File::delete($path);
        
    }

    public function goToTheProfessionnalForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'professionnal');
    }

    public function updatedEmail($email)
    {
        $this->validateOnly('email');
    }

    public function initializator()
    {
        $data = SubscriptionManager::getEmailData();

        if($data){

            $this->email = isset($data['email']) ? $data['email'] : null;
            $this->password = isset($data['password']) ? $data['password'] : null;
            $this->password_confirmation = isset($data['password_confirmation']) ? $data['password_confirmation'] : null;
            $this->photo_path = isset($data['photo_path']) ? $data['photo_path'] : null;

        }
    }
}
