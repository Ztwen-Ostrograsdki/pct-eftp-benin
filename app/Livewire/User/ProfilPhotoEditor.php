<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Toast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilPhotoEditor extends Component
{
    use WithFileUploads, Toast;

    public $user;

    public $profil_photo;

    public $counter = 0;

    public function render()
    {
        return view('livewire.user.profil-photo-editor');
    }

    public function close()
    {

    }

    public function save()
    {
        if($this->profil_photo){

            $extension = $this->profil_photo->extension();

            $file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

            $save = $this->profil_photo->storeAs("users/", $file_name . '.' . $extension, ['disk' => 'public']);

            if($save){

                Storage::delete($this->user->profil_photo);

                $update = $this->user->update(['profil_photo' => 'users/' . $file_name . '.' . $extension]);

                if($update){

                    $this->toast("Mise à jour réuissie !", 'success', 5000);

                    $this->counter = rand(2, 100);

                    $this->dispatch("UserProfilUpdated");
                    
                }
                else{

                    $this->toast("Une erreure est survenue, veuillez réessayer", 'error', 5000);
                }

            }
            else{

                $this->toast("Une erreure est survenue, veuillez réessayer", 'error', 5000);
            }
        }
    }
}
