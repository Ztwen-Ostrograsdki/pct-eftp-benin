<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Book;
use App\Models\Epreuve;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EpreuvesPage extends Component
{
    use Toast, Confirm, WithPagination;

    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_classes = [];

    public $counter = 0;



    public function render()
    {
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


        return view('livewire.libraries.epreuves-page', 
            [
                'epreuves' => $query->paginate(6),
            ]
        ); 
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
