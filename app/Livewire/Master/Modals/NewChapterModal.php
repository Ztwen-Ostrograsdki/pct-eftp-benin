<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitLawChaptersCreationEvent;
use App\Models\Law;
use App\Models\LawChapter;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewChapterModal extends Component
{
    
    use Toast;

    #[Validate('required|string')]
    public $chapter;

    public $description;

    public $law_id;

    public $editing = null;

    public $modal_name = "#chapter-manager-modal";

    public $counter = 2;

    public $law;

    public $chapters_data = [];

    public function render()
    {
        return view('livewire.master.modals.new-chapter-modal');
    }

    public function insert()
    {
        $data = $this->chapters_data;

        if($data){

            InitLawChaptersCreationEvent::dispatch($this->law, $data, auth_user());

            $this->reset();

            $this->resetErrorBag();

            $this->hideModal();
        }
    }

    public function pushIntoData()
    {
        $this->resetErrorBag();

        $this->validate();

        $data = $this->chapters_data;

        if($this->chapter){

            $existed = LawChapter::where('chapter', $this->chapter)->where('law_id', $this->law_id)->first();

            if(!$existed){

                if(!in_array($this->chapter, $data)){

                    $position = count($data) + 1;

                    $data[$position] = [
                        'chapter' => $this->chapter, 
                        'slug' => Str::slug($this->chapter), 
                        'description' => $this->description
                    ];

                    $this->chapters_data = $data;
    
                    $this->reset('description', 'chapter');
    
                    $this->resetErrorBag();
    
                }
    
            }
            else{

                $this->toast("Cet chapitre existe déjà au niveau de cette loi", "warning");

                $this->addError('chapter', "Ce champ existe déjà!");

            }

        }
    }


    public function resetAllData()
    {
        $this->reset('chapters_data');
    }


    public function removeFromData($chapter_position)
    {
        
        $data = $this->chapters_data;

        if(array_key_exists($chapter_position, $data)){

            unset($data[$chapter_position]);

            $this->chapters_data = $data;

        }
    }

    #[On('AddNewChapterEvent')]
    public function openModal($law_id = null)
    {
        if($law_id){

            $law = Law::find($law_id);

            if($law){

                $this->law = $law;

                $this->law_id = $law_id;

                $this->dispatch('OpenModalEvent', $this->modal_name);
            }
        }

    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
