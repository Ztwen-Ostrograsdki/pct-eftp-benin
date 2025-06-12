<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\SpatieManager;
use App\Models\ForumChatSubject;
use App\Models\Law;
use Livewire\Attributes\On;
use Livewire\Component;

class LawsPage extends Component
{
    use Toast, Confirm;

    public $search = '';

    public $counter = 1;

    public $laws_section_selected = 'pending';


    public function updatedForumChatSubjectSection($section)
    {
        session()->put('laws_section_selected', $this->laws_section_selected);
    }

    public function mount()
    {
        if(session()->has('laws_section_selected')){

            $this->laws_section_selected = session('laws_section_selected');

        }
    }

    public function render()
    {
        $allLaws = Law::all();

        if($this->laws_section_selected){

            
        }

        if($this->search && strlen($this->search) >= 3){

            

        }

        if(session()->has('laws_section_selected')){

            $this->laws_section_selected = session('laws_section_selected');

        }

        return view('livewire.master.laws-page', [
            'all_laws' => $allLaws
        ]);
    }

    public function searcher()
    {
        $this->search = $this->search;
    }

    public function newLaw()
    {
        SpatieManager::ensureThatUserCan();

        $this->dispatch("OpenLawManagerModal");
    }

    public function editLaw($law_id)
    {
        SpatieManager::ensureThatUserCan();

        $this->dispatch("OpenLawManagerModal", $law_id);
    }


    public function deleteLaw($law_id)
    {
        SpatieManager::ensureThatUserCan();

        $law = Law::find($law_id);

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

