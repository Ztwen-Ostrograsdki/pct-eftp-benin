<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToSendCommuniqueToMembersByMailEvent;
use App\Models\Communique;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CommuniquesListing extends Component
{

    use Toast, Confirm;


    public $counter = 2;

    #[Validate('required')]
    public $tasks;

    public function render()
    {

        $communiques = Communique::all();

        return view('livewire.master.communiques-listing', compact('communiques')
        );
    }


    public function manageCommnunique($communique_id = null)
    {
        $this->dispatch('ManageCommnuniqueEvent', $communique_id);
    }

   
    #[On('LiveUpdateCommuniquesListEvent')]
    public function reloadDataList()
    {
        $this->counter = getRand();
    }
    
    #[On('UpdatedCommuniquesList')]
    public function reloadData()
    {
        $this->counter = getRand();
    }

    public function sendCommuniqueToMemberByEmail($communique_id)
    {

        $admin_generator = auth_user();

        $communique = Communique::find($communique_id);

        if($communique){

            $event = InitProcessToSendCommuniqueToMembersByMailEvent::dispatch($admin_generator, $communique, null);
            
        }
    }

    public function deleteCommunique($communique_id)
    {

        $communique = Communique::find($communique_id);

        if($communique){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le communiqué: </p>
                            <p class='text-sky-400 letter-spacing-2 font-semibold'> {$communique->getCommuniqueFormattedName()} </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedCommuniqueDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['communique_id' => $communique->id]];

            $this->confirm($html, $noback, $options);

            
        }

    }

    #[On('confirmedCommuniqueDeletion')]
    public function onConfirmationCommuniqueDeletion($data)
    {
        if($data){

            $communique = $data['communique_id'];

            $communique = Communique::find($communique);

            if($communique){

                $communique->delete();

                $this->toast( "Le communiqué a été supprimé avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }

    public function hideOrUnHideCommunique($communique_id = null)
    {

        $communique = Communique::find($communique_id);

        if($communique){

            if($communique->hidden) $text = "rendre visible";

            else $text = "masquer";

            $html = "<h6 class='font-semibold text-base text-yellow-300-400 py-0 my-0'>
                            <p>Vous êtes sur le point de {$text} le communiqué: </p>
                            <p class='text-sky-400 letter-spacing-2 font-semibold'> {$communique->getCommuniqueFormattedName()} </p>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedCommuniqueHidden', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['communique_id' => $communique->id]];

            $this->confirm($html, $noback, $options);

            
        }

    }

    #[On('confirmedCommuniqueHidden')]
    public function onConfirmationCommuniqueHidden($data)
    {
        if($data){

            $communique_id = $data['communique_id'];

            $communique = Communique::find($communique_id);

            if($communique){

                if($communique->hidden) $text = "rendu visible";

                else $text = "masqué";

                $communique->update(['hidden' => !$communique->hidden]);

                $this->toast( "Le communiqué a été {$text} avec succès!", 'success');

            }
            else{

                $this->toast( "La modification a échoué! Veuillez réessayer!", 'error');
            }

        }

    }

}
