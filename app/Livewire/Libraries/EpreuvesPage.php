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

    public $carts_items = [];

    public $image_indexes = [];

    public $current_index = 0;


    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_classes = [];

    public $on_sale;

    public $is_active;

    public $step = 10000;

    public $price_range = 5000;

    public $min_price = 0;

    public $max_price = 90000000;

    public $counter = 0;



    public function render()
    {
        $query = Epreuve::query()->whereNotNull('created_at');


        return view('livewire.libraries.epreuves-page', 
            [
                'epreuves' => $query->paginate(6),
            ]
        ); 
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
