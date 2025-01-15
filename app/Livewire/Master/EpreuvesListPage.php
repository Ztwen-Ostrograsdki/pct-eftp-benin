<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\ENotification;
use App\Models\Epreuve;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EpreuvesListPage extends Component
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

        $query = Epreuve::query()->whereNotNull('created_at');

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

        if($this->selected_classes){



        }

        if($ids['has']){

            
            $query->whereIn('epreuves.id', $ids['items']);

        }

        if($this->selected_promotions !== []){

            $query->whereIn('epreuves.promotion_id', $this->selected_promotions);

        }

        if($search && strlen($search) >= 3 ){

            $find = '%' . $search . '%';

            $query->where('epreuves.contents_titles', 'like', $find);

        }

        if($this->authorized !== 'all'){
            $query->where('epreuves.authorized', $this->authorized);
        }

        return view('livewire.master.epreuves-list-page', 
            [
                'epreuves' => $query->paginate(6),
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

    public function validateEpreuve($epreuve_id)
    {
        $epreuve = Epreuve::find($epreuve_id);

        if($epreuve){

            if(!$epreuve->authorized){

                $user = $epreuve->user;

                $make = $epreuve->update(['authorized' => true]);

                if($make){

                    $auth = auth_user();

                    $this->toast("L'épreuve $epreuve->name a été publié avec succès et est désormais visible sur la plateforme");

                    $since = $epreuve->__getDateAsString($epreuve->created_at, 3, true);

                    $object = "Validation de votre épreuve publiée sur la plateforme";

                    $content = "Votre $epreuve->name épreuve publiée le " . $since . " a été approuvée par les administrateurs";
                    
                    $title = "Validation d'une épreuve publié";
                
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

    }
}
