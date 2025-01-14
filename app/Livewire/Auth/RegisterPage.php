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
    use Toast;

    public $is_perso_data_insertion = true;

    public $is_graduate_data_insertion = false;

    public $is_professionnal_data_insertion = false;

    public $is_password_data_insertion = false;

    public $to_confirm_data = false;

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
            $this->to_confirm_data = false;
        }
        elseif($section === 'professionnal'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = true;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
            $this->to_confirm_data = false;
        }
        elseif($section === 'perso'){
            $this->is_perso_data_insertion = true;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
            $this->to_confirm_data = false;
        }
        elseif($section === 'password'){
            $this->to_confirm_data = false;
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = true;
        }
        elseif($section === 'confirmed'){
            $this->to_confirm_data = true;
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function register()
    {

        

    }



    #[On('UpdateSectionInsertion')]
    public function updateTheSection($section)
    {
        if($section === 'graduate'){

            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = true;
            $this->is_password_data_insertion = false;
            $this->to_confirm_data = false;
        }
        elseif($section === 'professionnal'){
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = true;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
            $this->to_confirm_data = false;
        }
        elseif($section === 'perso'){
            $this->is_perso_data_insertion = true;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
            $this->to_confirm_data = false;
        }
        elseif($section === 'password'){
            $this->to_confirm_data = false;
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = true;
        }
        elseif($section === 'confirmed'){
            $this->to_confirm_data = true;
            $this->is_perso_data_insertion = false;
            $this->is_professionnal_data_insertion = false;
            $this->is_graduate_data_insertion = false;
            $this->is_password_data_insertion = false;
        }

        $this->section = $section;

        session()->put('register-section', $section);
    }
}

