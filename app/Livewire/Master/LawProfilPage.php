<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\SpatieManager;
use App\Models\Law;
use App\Models\LawChapter;
use Livewire\Attributes\On;
use Livewire\Component;

class LawProfilPage extends Component
{
    public $slug;

    public $law;

    public $law_id;

    public $counter = 3;


    use Toast, Confirm;

    public function mount($slug)
    {
        if($slug){

            $this->slug = $slug;
        }
        else{

            return abort(404);
        }
    }



    public function render()
    {
        if($this->slug){

            $law = Law::whereSlug($this->slug)->first();

            if($law) 

                $this->law = $law;

                $this->law_id = $law->id;

        }

        return view('livewire.master.law-profil-page');
    }


    public function editLaw($law_id = null)
    {
        SpatieManager::ensureThatUserCan();

        $law_id = $this->law_id;

        $this->dispatch("OpenLawManagerModal", $law_id);
    }


    public function deleteLaw($law_id = null)
    {
        SpatieManager::ensureThatUserCan();

        $law = $this->law;

        if($law){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer la loi: </p>
                            <p class='text-sky-400 letter-spacing-2 font-semibold'> $law->name </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedLawDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['law_id' => $law->id]];

            $this->confirm($html, $noback, $options);

            
        }

    }

    #[On('confirmedLawDeletion')]
    public function onConfirmationLawDeletion($data)
    {
        if($data){

            $law_id = $data['law_id'];

            $law = Law::find($law_id);

            if($law){

                $law->delete();

                $this->toast( "La loi a été supprimée avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }

    public function deleteChapter($chapter_id = null, $chapter = "le chapitre")
    {
        SpatieManager::ensureThatUserCan();

        $chapter = LawChapter::find($chapter_id);

        if($chapter){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le chapitre: </p>
                            <p class='text-sky-400 letter-spacing-2 font-semibold'> $chapter->chapter </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedChapterDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['chapter_id' => $chapter_id]];

            $this->confirm($html, $noback, $options);

            
        }

    }

    #[On('confirmedChapterDeletion')]
    public function onConfirmationChapterDeletion($data)
    {
        if($data){

            $chapter_id = $data['chapter_id'];

            $chapter = LawChapter::find($chapter_id);

            if($chapter){

                $chapter->delete();

                $this->toast( "Le chapitre a été supprimé avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }

    public function addNewChapter()
    {
        SpatieManager::ensureThatUserCan();

        $this->dispatch("AddNewChapterEvent", $this->law_id);
    }

    public function addNewArticle()
    {
        SpatieManager::ensureThatUserCan();
        
        $this->dispatch("AddNewArticleEvent", $this->law_id);
    }


    #[On("LiveUpdateLawEcosystemEvent")]
    public function relaodData()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveLawChaptersCreationCompletedEvent")]
    public function relaodLawData()
    {
        $this->counter = getRandom();
    }

   
}
