<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitEpreuveResponseUploadingEvent;
use App\Models\Epreuve;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EpreuveResponseUploader extends Component
{
    use WithFileUploads, Toast, Confirm;
    
    public $uploaded_completed = false;
    
    public $counter = 0;

    public $name;

    public $the_file;

    public $path;

    public $user_id;

    public $epreuve_id;

    public $epreuve;


    public function render()
    {
        $epreuve = null;

        if($this->epreuve_id){

            $epreuve = Epreuve::find($this->epreuve_id);

        }
        

        if($epreuve){

            $this->name = "Elements-de-réponse-de-" . $epreuve->baseName();
        }

        $this->epreuve = $epreuve;

        return view('livewire.libraries.epreuve-response-uploader');
    }

   

    public function updatedFileEpreuve($file)
    {
        $this->resetErrorBag();
    }
    
    public function uploadEpreuve()
    {
        $this->resetErrorBag();


        $this->validate([
            'the_file' => 'required|file|mimes:docx,pdf|max:8000',
        ]);

        $epreuve = $this->epreuve;
        

        $path = null;

        if($this->the_file){

            $extension = $this->the_file->extension();

            $file_name = $this->name . '-' . count($epreuve->answers) + 1;

            $this->name = Str::upper($this->name);

        }

        $file_size = '0 Ko';

        if($this->the_file->getSize() >= 1048580){

            $file_size = number_format($this->the_file->getSize() / 1048576, 2) . ' Mo';

        }
        else{

            $file_size = number_format($this->the_file->getSize() / 1000, 2) . ' Ko';

        }

        $path = 'corriges_epreuves/' . $file_name . '.' . $extension;

        $user = User::find(auth_user_id());

        $authorized = $user->isAdminsOrMaster() || $user->hasRole(['epreuves-manager']);

        $data = [
            'name' => $this->name,
            'user_id' => $user->id,
            'extension' => "." . $extension,
            'file_size' => $file_size,
            'epreuve_id' => $this->epreuve_id,
            'path' => $path,
            'authorized' => $authorized,
        ];

        $root = storage_path("app/public/corriges_epreuves");

        $directory_make = false;

        if(!File::isDirectory($root)){

            $directory_make = File::makeDirectory($root, 0777, true, true);

        }
        else{

            $directory_make = true;
        }

        if(!File::isDirectory($root) || !$directory_make){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');


           return  Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

        }

        $file_saved_path = $this->the_file->storeAs("corriges_epreuves/", $file_name . '.' . $extension, ['disk' => 'public']);

        if($file_saved_path){

            InitEpreuveResponseUploadingEvent::dispatch($data, $file_saved_path);

            $this->reset('the_file');

            $this->uploaded_completed = true;
        }
        else{

            $this->toast("Une erreure est survenue", 'error');
        }

    }


}
