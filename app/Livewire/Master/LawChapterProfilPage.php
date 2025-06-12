<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\SpatieManager;
use App\Models\LawChapter;
use Livewire\Attributes\On;
use Livewire\Component;

class LawChapterProfilPage extends Component
{
    public $slug;

    public $chapter_slug;

    public $chapter;

    public $law;

    public $chapter_id;

    public $counter = 3;


    use Toast, Confirm;

    public function mount($slug, $chapter_slug)
    {
        if($slug && $chapter_slug){

            $this->slug = $slug;

            $this->chapter_slug = $chapter_slug;
        }
        else{

            return abort(404);
        }
    }
    
    public function render()
    {
        if($this->chapter_slug){

            $chapter = LawChapter::whereSlug($this->chapter_slug)->first();

            if($chapter) 

                $this->chapter = $chapter;

                $this->chapter_id = $chapter->id;

                $this->law = $chapter->law;

        }

        return view('livewire.master.law-chapter-profil-page');
    }


    public function addNewArticle()
    {
        SpatieManager::ensureThatUserCan();
        
        $this->dispatch("AddNewArticleEvent", $this->chapter_id);
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
