<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Epreuve;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EpreuveProfil extends Component
{
    use Toast, Confirm, WithFileUploads;

    public $counter = 3, $uuid, $uplaod_new_file = false;


    public function mount($uuid)
    {
        if($uuid){

            $this->uuid = $uuid;
        }
        else{

            return abort(404);
        }
    }


    public function render()
    {
        if(session()->has('epreuve-profil-section')){

            $this->uplaod_new_file = session('epreuve-profil-section');

        }
        $epreuve = Epreuve::where('uuid', $this->uuid)->with('answers')->first();
        
        return view('livewire.libraries.epreuve-profil', compact('epreuve'));
    }

    public function addNewResponse()
    {
        $this->uplaod_new_file = !$this->uplaod_new_file;

        session()->put('epreuve-profil-section', $this->uplaod_new_file);
    }


    #[On("LiveNewEpreuveResponseHasBeenPublishedEvent")]
    public function newResponsePublished()
    {
        $this->counter = getRand();
    }
}
