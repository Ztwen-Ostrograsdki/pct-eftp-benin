<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Models\ENotification;
use App\Models\SupportFile;
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

    public function validateSupportFile($fiche_id)
    {
        SpatieManager::ensureThatUserCan(['epreuves-manager']);

        $fiche = SupportFile::find($fiche_id);

        if($fiche){

            if(!$fiche->authorized){

                $user = $fiche->user;

                $make = $fiche->update(['authorized' => true]);

                if($make){

                    $auth = auth_user();

                    $this->toast("La fiche de cours $fiche->name a été publié avec succès et est désormais visible sur la plateforme");

                    $since = $fiche->__getDateAsString($fiche->created_at, 3, true);

                    $object = "Validation de votre fiche de cours publiée sur la plateforme";

                    $content = "Votre fiche de cours $fiche->name publiée le " . $since . " a été approuvée par les administrateurs";
                    
                    $title = "Validation d'une fiche de cours publié";
                
                    $data = [
                        'user_id' => $auth->id,
                        'content' => $content,
                        'title' => $title,
                        'object' => $object,
                        'receivers' => [$user->id],

                    ];

                    $enotif = ENotification::create($data);
                }

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
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $support_file = SupportFile::find($id);

        $support_file->downloadManager();

        $path = storage_path().'/app/public/' . $support_file->path;

        return response()->download($path);
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
