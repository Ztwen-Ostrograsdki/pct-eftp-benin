<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Models\ENotification;
use App\Models\SupportFile;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SupportFilesListPage extends Component
{

    use Toast, Confirm, WithPagination;

    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_classes = [];

    public $counter = 0;

    public $authorized = 'all';

    public $search = '';



    public function render()
    {
        $search = $this->search;

        $query = SupportFile::query()->whereNotNull('created_at');

        $ids = [
            'has' => false,
            'items' => [],
        ];

        if($this->selected_filiars !== []){

            $ids['has'] = true;

            $support_files = SupportFile::all();

            foreach($support_files as $e){
                
                foreach($this->selected_filiars as $id){

                    if($e->isForThisFiliar($id)){

                        $ids['items'][] = $e->id;
                    }
                }
            }

        }

        if($this->selected_classes){



        }

        if($ids['has']){

            
            $query->whereIn('support_files.id', $ids['items']);

        }

        if($this->selected_promotions !== []){

            $query->whereIn('support_files.promotion_id', $this->selected_promotions);

        }

        if($search && strlen($search) >= 3 ){

            $find = '%' . $search . '%';

            $query->where('support_files.contents_titles', 'like', $find);

            $query->whereAny(['support_files.contents_titles', 'support_files.name', 'support_files.uuid', 'support_files.school_year', 'support_files.description'], 'like', $find);

        }

        if($this->authorized !== 'all'){
            $query->where('support_files.authorized', $this->authorized);
        }

        return view('livewire.master.support-files-list-page', 
            [
                'support_files' => $query->paginate(6),
            ]
        ); 
    }

    public function resetSearch()
    {
        $this->reset('search');
    }

    public function clearAll()
    {
        $this->reset();
    }

    public function validateSupportFile($support_file_id)
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $fiche = SupportFile::find($support_file_id);

        if($fiche){

            if(!$fiche->authorized){

                $user = $fiche->user;

                $make = $fiche->update(['authorized' => true, 'hidden' => false]);

                if($make){

                    $this->toast("La fiche $fiche->name a été approuvée et publiée avec succès!", "success");

                    $since = $fiche->__getDateAsString($fiche->created_at, 3, true);

                    $message = "Votre épreuve $fiche->name publiée le " . $since . " a été approuvée par les administrateurs";
                    
                    Notification::sendNow([$user], new RealTimeNotificationGetToUser($message));
                    
                }

            }

        }
    }

    public function hidde($support_file_id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $fiche = SupportFile::find($support_file_id);

        if($fiche){

            $uuid = $fiche->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de masquer le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Le fichier ne sera plus accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedHidden', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé', 'data' => ['support_file_id' => $fiche->id]];

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

            $support_file_id = $data['support_file_id'];

            $fiche = SupportFile::find($support_file_id);

            if($fiche){

                $updated = $fiche->update(['hidden' => true]);

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

    public function unHidde($support_file_id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $fiche = SupportFile::find($support_file_id);

        if($fiche){

            $uuid = $fiche->uuid;

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                            <p>Vous êtes sur le point de rendre accessible le fichier {$uuid}  </p>
                            
                    </h6>";
            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'>Cette fiche sera de nouveau accessible sur le plateforme! </p>";

            $options = ['event' => 'confirmedUnHidden', 'confirmButtonText' => 'Rendre accessible', 'cancelButtonText' => 'Annulé', 'data' => ['support_file_id' => $fiche->id]];

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

            $support_file_id = $data['support_file_id'];

            $fiche = SupportFile::find($support_file_id);

            if($fiche){

                $updated = $fiche->update(['hidden' => false]);

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



    public function updatedSearch($search)
    {
    }

    public function updatedSelectedPromotions($values)
    {
    }

    public function updatedSelectedFiliars($values)
    {
    }

    #[On('LiveSupportFileWasCreatedSuccessfullyEvent')]
    public function newEpreuveCreated()
    {
        $this->toast("Une nouvelle fiche de cours a été ajoutée", 'success');

        $this->counter = rand(12, 300);
    }

    public function downloadTheFile($id)
    {
        $this->toast("Téléchargement lancé... patientez", 'success');

        $support_file = SupportFile::find($id);

        if($support_file){

            $path = storage_path().'/app/public/' . $support_file->path;

            if(File::exists($path)){

                $support_file->downloadManager();

                return response()->download($path);
            }
            else{
                return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
            }
        }
        else{
            return $this->toast("Une erreure s'est produite: le fichier est introuvable ou été supprimé!", 'error');
        }
    }

    public function deleteFile($id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $support = SupportFile::find($id);

        if($support){

            $uuid = $support->uuid;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le fichier {$uuid} </p>
                            
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

            $support = SupportFile::find($file_id);

            if($support){

                $del_from_db = $support->delete();

                if($del_from_db){

                    return $this->toast("Le fichier a été supprimé!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été supprimé!", 'error');
                }
            }

        }
    }
}
