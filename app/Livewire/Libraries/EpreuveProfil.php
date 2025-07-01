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

    public function approveEpreuve()
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::where('uuid', $this->uuid)->with('answers')->first();

        if($epreuve){

            if(!$epreuve->authorized){

                $user = $epreuve->user;

                $make = $epreuve->update(['authorized' => true, 'hidden' => false]);

                if($make){

                    $this->toast("L'épreuve $epreuve->name a été approuvée et publiée avec succès!", "success");

                    $since = $epreuve->__getDateAsString($epreuve->created_at, 3, true);

                    $message = "Votre épreuve $epreuve->name publiée le " . $since . " a été approuvée par les administrateurs";
                    
                    Notification::sendNow([$user], new RealTimeNotificationGetToUser($message));
                    
                }

            }

        }
    }

    public function approvedResponse($response_id)
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve_response = EpreuveResponse::find($response_id);

        if($epreuve_response){

            if(!$epreuve_response->authorized){

                $user = $epreuve_response->user;

                $make = $epreuve_response->update(['authorized' => true, 'hidden' => false]);

                if($make){

                    $this->toast("Le fichier $epreuve_response->name a été approuvé et publié avec succès!", "success");

                    $since = __formatDate($epreuve_response->created_at);

                    $message = "Votre élément de réponses $epreuve_response->uuid publié le " . $since . " a été approuvée par les administrateurs";
                    
                    Notification::sendNow([$user], new RealTimeNotificationGetToUser($message));
                    
                }

            }

        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
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
        
                        $make = $epreuve_response->update(['authorized' => true, 'hidden' => false]);
        
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
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    public function downloadTheFile($id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $epreuve = Epreuve::find($id);

        $path = storage_path().'/app/public/' . $epreuve->path;

        if($epreuve && File::exists($path)){

            $epreuve->downloadManager();

            return response()->download($path);

        }
        else{

            return $this->toast("Le fichier est introuvable ou a été supprimé!", 'error');
        }
    }

    public function downloadTheAnswer($id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $epreuve_response = EpreuveResponse::find($id);

        $path = storage_path().'/app/public/' . $epreuve_response->path;

        if($epreuve_response && File::exists($path)){

            $epreuve_response->downloadManager();

            return response()->download($path);
        } 
        else{
            
            return $this->toast("Le fichier est introuvable ou a été supprimé!", 'error');
        }

    }

    public function hidde()
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::where('uuid', $this->uuid)->first();

        if($epreuve){

            $uuid = $epreuve->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de masquer le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> L'épreuve ne sera plus accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedHidden', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé', 'data' => ['epreuve_id' => $epreuve->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    #[On('confirmedHidden')]
    public function onConfirmationToHidde($data)
    {
        if($data){

            $epreuve_id = $data['epreuve_id'];

            $epreuve = Epreuve::find($epreuve_id);

            if($epreuve){

                $updated = $epreuve->update(['hidden' => true]);

                if($updated){

                    return $this->toast("Le fichier a été masqué avec succès et ne sera plus accessible sur la plateforme!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été masqué!", 'error');
                }
            }
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }

        }
    }

    public function unHidde()
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::where('uuid', $this->uuid)->first();

        if($epreuve){

            $uuid = $epreuve->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de rendre accessible le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'>L'épreuve sera de nouveau accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedUnHidden', 'confirmButtonText' => 'Rendre accessible', 'cancelButtonText' => 'Annulé', 'data' => ['epreuve_id' => $epreuve->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    #[On('confirmedUnHidden')]
    public function onConfirmationToUnHidde($data)
    {
        if($data){

            $epreuve_id = $data['epreuve_id'];

            $epreuve = Epreuve::find($epreuve_id);

            if($epreuve){

                $updated = $epreuve->update(['hidden' => false]);

                if($updated){

                    return $this->toast("Le fichier a été rendu accessible sur la plateforme!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été démasqué!", 'error');
                }
            }
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }

        }
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
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
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
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
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

            $options = ['event' => 'confirmedFilesDeletion', 'confirmButtonText' => 'Tout Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['epreuve_id' => $epreuve->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
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
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }

        }

    }


    public function hiddeResponse($response_id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve_response = EpreuveResponse::find($response_id);

        if($epreuve_response){

            $uuid = $epreuve_response->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de masquer le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> L'épreuve ne sera plus accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedResponseHidden', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['response_id' => $epreuve_response->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    #[On('confirmedResponseHidden')]
    public function onConfirmationToHiddeResponse($data)
    {
        if($data){

            $response_id = $data['response_id'];

            $epreuve_response = EpreuveResponse::find($response_id);

            if($epreuve_response){

                $updated = $epreuve_response->update(['hidden' => true]);

                if($updated){

                    return $this->toast("Le fichier a été masqué avec succès et ne sera plus accessible sur la plateforme!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été masqué!", 'error');
                }
            }
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }

        }
    }

    public function unHiddeResponse($response_id)
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve_response = EpreuveResponse::find($response_id);

        if($epreuve_response){

            $uuid = $epreuve_response->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de rendre accessible le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'>L'épreuve sera de nouveau accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedUnHiddenResponse', 'confirmButtonText' => 'Rendre accessible', 'cancelButtonText' => 'Annulé', 'data' => ['response_id' => $epreuve_response->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    #[On('confirmedUnHiddenResponse')]
    public function onConfirmationToUnHiddeResponse($data)
    {
        if($data){

            $response_id = $data['response_id'];

            $epreuve_response = EpreuveResponse::find($response_id);

            if($epreuve_response){

                $updated = $epreuve_response->update(['hidden' => false]);

                if($updated){

                    return $this->toast("Le fichier a été rendu accessible sur la plateforme!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été démasqué!", 'error');
                }
            }
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }

        }
    }

    #[On("LiveNewEpreuveResponseHasBeenPublishedEvent")]
    public function newResponsePublished()
    {
        $this->counter = getRand();
    }
}
