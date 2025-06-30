<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Helpers\Tools\SpatieManager;
use App\Models\Epreuve;
use App\Models\Lycee;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EpreuvesExamensPage extends Component
{
    
    use Toast, Confirm, WithPagination;

    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_year;

    public $selected_type;

    public $selected_lycee_id;

    public $selected_department = null;

    public $is_normal_exams = 'twice';

    public $counter = 0;

    public $search = '';


    public function render()
    {
        $search = $this->search;

        $query = Epreuve::query()->where('epreuves.authorized', true)->where('epreuves.is_exam', true);

        $types = config('app.examen_types');

        $departments = RobotsBeninHelpers::getDepartments();

        $lycees = Lycee::all();

        $ids = [
            'has' => false,
            'items' => [],
        ];

        if($this->selected_filiars !== []){

            $ids['has'] = true;

            $epreuves = Epreuve::all();

            foreach($epreuves as $e){
                
                foreach($this->selected_filiars as $id){

                    if($e->isForThisFiliar($id)){

                        $ids['items'][] = $e->id;
                    }
                }
            }

        }

        if($this->selected_type){

            $query->where('exam_type', $this->selected_type);

        }

        if($this->selected_department){

            $query->where('exam_department', $this->selected_department);

        }
        if($this->selected_lycee_id){

            $query->where('lycee_id', $this->selected_lycee_id);

        }

        if($this->is_normal_exams !== 'twice'){

            $query->where('is_normal_exam', $this->is_normal_exams);

        }

        if($ids['has']){

            
            $query->whereIn('epreuves.id', $ids['items']);

        }

        if($this->selected_promotions !== []){

            $query->whereIn('epreuves.promotion_id', $this->selected_promotions);

        }

        if($search && strlen($search) >= 3 ){

            $find = '%' . $search . '%';

            $query->where('epreuves.contents_titles', 'like', $find)
                  ->orWhere('epreuves.school_year', 'like', $find);


        }

        if($this->selected_year) $query->where('epreuves.school_year', $this->selected_year);

        return view('livewire.libraries.epreuves-examens-page', 
            [
                'epreuves' => $query->paginate(6),
                'types' => $types,
                'departments' => $departments,
                'lycees' => $lycees,
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

    public function updatedIsNormalExams($value)
    {
        if($value === true && $value !== 'twice') $this->reset('selected_lycee_id');
        
    }



    public function updatedSearch($search)
    {
        if(strlen($search) == 4 && is_numeric($search)) $this->selected_year = (int)$search;
    }

    public function updatedSelectedYear($year)
    {

    }

    public function updatedSelectedPromotions($values)
    {
    }

    public function updatedSelectedFiliars($values)
    {
    }

    #[On('LiveEpreuveWasCreatedSuccessfullyEvent')]
    public function newEpreuveCreated()
    {
        $this->toast("Une nouvelle épreuve a été ajoutée", 'success');

        $this->counter = rand(12, 300);
    }

    public function downloadTheFile($id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $epreuve = Epreuve::find($id);

        $epreuve->downloadManager();

        $path = storage_path().'/app/public/' . $epreuve->path;

        return response()->download($path);
    }

    public function deleteFile($id)
    {

        SpatieManager::ensureThatUserCan(['epreuves-manager']);
        
        $epreuve = Epreuve::find($id);

        if($epreuve){

            $uuid = $epreuve->uuid;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le fichier de {$uuid} </p>
                            
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

            $epreuve = Epreuve::find($file_id);

            if($epreuve){

                $del_from_db = $epreuve->delete();

                if($del_from_db){

                    return $this->toast("Le fichier a été supprimé!", 'success');
                }
                else{

                    return $this->toast("Une erreure s'est produite: le fichier n'a pas été supprimé!", 'error');
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

