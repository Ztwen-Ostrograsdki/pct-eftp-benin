<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Component;

class GraduateManagerModule extends Component
{
    protected $listeners = [
        
    ];

    use Toast, Confirm;

    public $user;

    public $graduate_title = "Diplôme";
    public $editing_graduate = false;


    public $hidden_graduate = false;

    public $graduate;
    public $graduate_year;
    public $graduate_deliver;
    public $graduate_type;


    public function mount()
    {

        if($this->user){

            $user = $this->user;

            $this->graduate = $user->graduate ? $this->user->graduate : 'Non renseigné';
            $this->graduate_year = $user->graduate_year ? $this->user->graduate_year : 'Non renseigné';
            $this->graduate_type = $user->graduate_type ? $this->user->graduate_type : 'Non renseigné';
            $this->graduate_deliver = $user->graduate_deliver ? $this->user->graduate_deliver : 'Non renseigné';
            
        }

    }

    public function startGraduateEdition()
    {
        $this->editing_graduate = true;

    } 

    public function toggleGraduateSection()
    {
        $this->hidden_graduate = !$this->hidden_graduate;

    }

    public function cancelGraduateEdition()
    {
        $this->editing_graduate = false;

        $user = $this->user;

        if($user){

            $this->graduate = $user->graduate ? $this->user->graduate : 'Non renseigné';
            $this->graduate_year = $user->graduate_year ? $this->user->graduate_year : 'Non renseigné';
            $this->graduate_type = $user->graduate_type ? $this->user->graduate_type : 'Non renseigné';
            $this->graduate_deliver = $user->graduate_deliver ? $this->user->graduate_deliver : 'Non renseigné';
        }
    }

   

    public function render()
    {
        return view('livewire.user.graduate-manager-module');
    }
}
