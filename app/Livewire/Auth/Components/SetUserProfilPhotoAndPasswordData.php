<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
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

    protected $rules = [
        'email' => 'required|email|unique:users|min:3|max:255',
        'password' => 'string|required|min:8|confirmed:password',
        'password_confirmation' => 'string|required',
        'profil_photo' => 'required|image|mimes:jpeg,png,jpg|max:4000',
    ];

    
    
    public function render()
    {
        return view('livewire.auth.components.set-user-profil-photo-and-password-data');
    }


    public function validatePasswordAndProfil()
    {
        //$this->dispatch("UpdateSectionInsertion", 'confirmed');
    }

    public function goToTheProfessionnalForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'professionnal');
    }

    public function updatedEmail($email)
    {
        $this->validateOnly('email');
    }
}
