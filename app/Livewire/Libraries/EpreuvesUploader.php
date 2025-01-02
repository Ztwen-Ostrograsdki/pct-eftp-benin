<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitEpreuveCreationEvent;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EpreuvesUploader extends Component
{
    use WithFileUploads, Toast, Confirm;
    
    public $counter = 0;

    #[Validate('string|max:60')]
    public $name;

    public $selecteds = [];

    public $description;

    public $author;

    #[Validate('required|file|mimes:docx,pdf|max:8000')]
    public $file_epreuve;

    public $path;

    public $images;

    #[Validate('required|string')]
    public $contents_titles;

    #[Validate('required')]
    public $filiars_ids = [];

    #[Validate('required')]
    public $promotion_id;

    public $user_id;


    public function mount()
    {
        if(auth_user()) 
            $this->author = auth_user_fullName();

    }

    public function render()
    {
        $filiars = getFiliars();

        $classes = getClasses();

        $promotions = getPromotions();

        return view('livewire.libraries.epreuves-uploader', [
            'classes' => $classes,
            'filiars' => $filiars,
            'promotions' => $promotions,
        ]);
    }

    public function pushIntoSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(!in_array($id, $selecteds)){

            $selecteds[] = $id;
        }

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->selecteds = $selecteds;
    }

    public function uploadEpreuve()
    {
        $this->filiars_ids = $this->selecteds;

        if(!$this->name) $this->name = Str::random(8);

        $this->validate();

        $path = null;

        if($this->file_epreuve){

            $extension = $this->file_epreuve->extension();

            $file_name = 'EPREUVE-' . getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'].'-'.getdate()['hours'].''.getdate()['minutes'].'-'.getdate()['seconds']. '-' .  Str::random(5);

            $path = 'epreuves/' . $file_name . '.' . $extension;

        }

        $file_size = '0 Ko';

        if($this->file_epreuve->getSize() >= 1048580){

            $file_size = number_format($this->file_epreuve->getSize() / 1048576, 2) . ' Mo';

        }
        else{

            $file_size = number_format($this->file_epreuve->getSize() / 1000, 2) . ' Ko';

        }

        $data = [
            'name' => $this->name,
            'user_id' => auth_user()->id,
            'contents_titles' => $this->contents_titles,
            'description' => $this->description,
            'filiars_id' => $this->filiars_ids,
            'promotion_id' => $this->promotion_id,
            'extension' => "." . $extension,
            'file_size' => $file_size,
            'path' => $path,
        ];

        $save = $this->file_epreuve->storeAs("epreuves/", $file_name . '.' . $extension, ['disk' => 'public']);

        if($save){

            InitEpreuveCreationEvent::dispatch($data, $save);

            $this->reset();
        }
        else{

            $this->toast("Une erreure est survénue", 'error');
        }
        

    }


    #[On('LiveEpreuveWasCreatedSuccessfullyEvent')]
    public function newEpreuveCreated()
    {
        $this->toast("Une nouvelle épreuve a été ajoutée", 'success');

        $this->counter = rand(12, 300);
    }

    
}
