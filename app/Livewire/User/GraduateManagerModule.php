<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
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

    protected $rules = [
        'graduate' => 'string|required',
        'graduate_year' => 'string|required',
        'graduate_type' => 'string|required',
        'graduate_deliver' => 'string|required',
    ];


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

    public function updateUserGraduateData()
    {
        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");

        $this->resetErrorBag();

        $this->validate();

        $data = [
            'graduate' => $this->graduate,
            'graduate_deliver' => $this->graduate_deliver,
            'graduate_type' => $this->graduate_type,
            'graduate_year' => $this->graduate_year,
        ];

        $options = ['event' => 'confirmedUserGraduateDataUpdate', 'data' => $data];

        $this->confirm("Confirmation de la mise à jour des données de " . $this->user->getFullName(true), "Cette action est irréversible", $options);

    }

    #[On('confirmedUserGraduateDataUpdate')]
    public function onConfirmationUserGraduateDataUpdate($data)
    {
        if($this->user->id !== Auth::user()->id) return abort(403, "Vous n'êtes pas authorisé!");
        
        if($data){

            $user = $this->user->update($data);

            if($user){

                $message = "La mise à jour est terminée.";

                $this->toast($message, 'success');

                session()->flash('success', $message);

                $this->cancelGraduateEdition();
                
            }
            else{

                $this->toast( "La mise à jour a échoué! Veuillez réessayer!", 'error');

            }
        }

    }
}
