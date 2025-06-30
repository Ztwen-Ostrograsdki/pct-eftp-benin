<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Models\Epreuve;
use App\Models\EpreuveResponse;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\TryCatch;

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

    public function approvedResponse($response_id)
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve_response = EpreuveResponse::find($response_id);

        if($epreuve_response){

            if(!$epreuve_response->authorized){

                $user = $epreuve_response->user;

                $make = $epreuve_response->update(['authorized' => true]);

                if($make){

                    $this->toast("Le fichier $epreuve_response->name a été approuvé et publié avec succès!", "success");

                    $since = __formatDate($epreuve_response->created_at);

                    $message = "Votre élément de réponses $epreuve_response->uuid publié le " . $since . " a été approuvée par les administrateurs";
                    
                    Notification::sendNow([$user], new RealTimeNotificationGetToUser($message));
                    
                }

            }

        }
    }

    public function approvedAllResponses()
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::where('uuid', $this->uuid)->with('answers')->first();

        if($epreuve){

            $answers = $epreuve->answers;

            if(count($answers)){

                foreach($answers as $epreuve_response){

                    if(!$epreuve_response->authorized){

                        $user = $epreuve_response->user;
        
                        $make = $epreuve_response->update(['authorized' => true]);
        
                        if($make){
        
                            $this->toast("Le fichier $epreuve_response->name a été approuvé et publié avec succès!", "success");
        
                            $since = __formatDate($epreuve_response->created_at);
        
                            $message = "Votre élément de réponses $epreuve_response->uuid publié le " . $since . " a été approuvée par les administrateurs";
                            
                            Notification::sendNow([$user], new RealTimeNotificationGetToUser($message));
                            
                        }
        
                    }
                }
            }

        }
    }

    public function downloadTheFile($id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $epreuve = Epreuve::find($id);

        $epreuve->downloadManager();

        $path = storage_path().'/app/public/' . $epreuve->path;

        if($epreuve && File::exists($path)) 

            return response()->download($path);

        else 
            return $this->toast("Le fichier est introuvable ou a été supprimé!", 'error');

    }

    public function downloadTheAnswer($id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $epreuve_response = EpreuveResponse::find($id);

        $epreuve_response->downloadManager();

        $path = storage_path().'/app/public/' . $epreuve_response->path;

        if($epreuve_response && File::exists($path)) 

            return response()->download($path);

        else 
            return $this->toast("Le fichier est introuvable ou a été supprimé!", 'error');
    }

    public function deleteFile($id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve_response = EpreuveResponse::find($id);

        if($epreuve_response){

            $uuid = $epreuve_response->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le fichier {$uuid} proposé comme éléments de réponses  </p>
                            
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedFileDeletion', 'confirmButtonText' => 'Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['file_id' => $id]];

            $this->confirm($html, $noback, $options);
            
        }
    }

    #[On('confirmedFileDeletion')]
    public function onConfirmationFileDeletion($data)
    {
        if($data){

            $file_id = $data['file_id'];

            $epreuve_response = EpreuveResponse::find($file_id);

            if($epreuve_response){

                $del_from_db = $epreuve_response->delete();

                if($del_from_db){

                    return $this->toast("Le fichier a été supprimé!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été supprimé!", 'error');
                }
            }

        }
    }
    
    public function deleteAllResponses()
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::where('uuid', $this->uuid)->first();

        if($epreuve){

            $uuid = $epreuve->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer tous fichiers éléments de réponses proposés pour l'épreuve {$uuid} </p>
                            
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedFilesDeletion', 'confirmButtonText' => 'Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['epreuve_id' => $epreuve->id]];

            $this->confirm($html, $noback, $options);
            
        }
    }

    #[On('confirmedFilesDeletion')]
    public function onConfirmationFilesDeletion($data)
    {
        if($data){

            DB::beginTransaction();

            $epreuve_id = $data['epreuve_id'];

            $epreuve = Epreuve::find($epreuve_id);

            if($epreuve){

                try {
                    foreach($epreuve->answers as $epreuve_response){

                        $epreuve_response->delete();
                        
                    }

                    DB::commit();

                    return $this->toast("Les fichiers ont été supprimé!", 'success');

                } catch (\Throwable $th) {

                    $this->toast("Une erreure s'est produite: les fichiers n'ont pas été supprimés!", 'error');
                    
                    DB::rollBack();
                }
            }

        }

    }

    #[On("LiveNewEpreuveResponseHasBeenPublishedEvent")]
    public function newResponsePublished()
    {
        $this->counter = getRand();
    }
}
