<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitSupportFileCreationEvent;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;


#[Title("Publier une fiche ou un support de cours")]
class SupportFilesUploader extends Component
{
    use WithFileUploads, Toast, Confirm;
    
    public $counter = 0;

    #[Validate('string|max:60')]
    public $name;

    public $selecteds = [];

    public $description;

    public $author;

    #[Validate('required|file|mimes:docx,pdf|max:8000')]
    public $support_file;

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

        return view('livewire.libraries.support-files-uploader', [
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

            $selecteds[$id] = $id;
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

    public function uploadSupportFile()
    {
        $this->filiars_ids = $this->selecteds;

        $filiars = [];

        if(!$this->name) $this->name = Str::random(8);

        $this->validate();

        $path = null;

        $selecteds = $this->selecteds;

        if($this->support_file){

            $extension = $this->support_file->extension();

            $str = '';

            if($this->name){
                
                $str = str_replace(' ', '-', $this->name);
            }

            $file_name = 'FICHE-' . getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday']. $str . '-' .  Str::random(5);

            $path = 'fiches/' . $file_name . '.' . $extension;

            foreach($selecteds as $fid){

                $filiars[] = $fid;

            }

        }

        $file_size = '0 Ko';

        if($this->support_file->getSize() >= 1048580){

            $file_size = number_format($this->support_file->getSize() / 1048576, 2) . ' Mo';

        }
        else{

            $file_size = number_format($this->support_file->getSize() / 1000, 2) . ' Ko';

        }

        $data = [
            'name' => $this->name,
            'user_id' => auth_user()->id,
            'contents_titles' => $this->contents_titles,
            'description' => $this->description,
            'filiars_id' => $filiars,
            'promotion_id' => $this->promotion_id,
            'extension' => "." . $extension,
            'file_size' => $file_size,
            'path' => $path,
            'authorized' => 0,
        ];

        $save = $this->support_file->storeAs("fiches/", $file_name . '.' . $extension, ['disk' => 'public']);

        if($save){

            InitSupportFileCreationEvent::dispatch($data, $save);

            $this->reset();
        }
        else{

            $this->toast("Une erreure est survénue", 'error');
        }
        

    }


    #[On('LiveSupportFileWasCreatedSuccessfullyEvent')]
    public function newSupportFileCreated()
    {
        $message = "Votre fiche de cours a été publiée avec succès. Elle sera analysée et validée par les administrateurs avant d'être visible par tous!";

        $this->toast($message, 'success');

        to_flash('support-file-success', $message);

        $this->counter = rand(12, 300);
    }

        
}
