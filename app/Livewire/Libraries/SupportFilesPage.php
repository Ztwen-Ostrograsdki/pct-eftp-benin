<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Models\SupportFile;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SupportFilesPage extends Component
{
    use Toast, Confirm, WithPagination;

    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_classes = [];

    public $counter = 0;

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

        $query->where('support_files.authorized', true);



        return view('livewire.libraries.support-files-page', 
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
    public function newSupportFileCreated()
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
        
        $support_file = SupportFile::find($id);

        if($support_file){

            $del = ModelsRobots::deleteFileFromStorageManager($support_file->path);

            if($del){

                $this->toast("Le support de cours a été supprimée avec succès!", 'success');

                $this->counter = rand(12, 300);

                return false;
            }
            else{

                $this->toast("Une erreur s'est produite lors de la suppression de $support_file->name", 'error');

            }
        }
    }
}
