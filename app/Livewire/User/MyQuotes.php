<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Quote;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class MyQuotes extends Component
{
    use Toast, Confirm;

    public $user;

    public $member;

    public $counter = 0;

    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;

                if($user->member) 

                    $this->member = $user->member;

                else 
                    return abort(403, "Accès non authorisé");
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
    }


    public function render()
    {
        $quotes = $this->user->quotes;

        return view('livewire.user.my-quotes', compact('quotes'));
    }


    public function manageQuote($quote_id = null)
    {
        if(Gate::denies('is_self_user', $this->user->id)){

            return abort(403, "Action non authorisée!");
        }

        $this->dispatch('OpenMemberQuoteManagerModal', $quote_id);
    }
    
    public function AddNewQuote()
    {
        if(Gate::denies('is_self_user', $this->user->id)){

            return abort(403, "Action non authorisée!");
        }
        $this->dispatch('OpenMemberQuoteManagerModal', null);
    }

    public function deleteQuote($quote_id)
    {

        if(Gate::denies('is_self_user', $this->user->id)){

            return abort(403, "Action non authorisée!");
        }

        $quote = Quote::find($quote_id);

        if($quote){

            $content = $quote->content;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer la citation  </p>
                            <p class='text-sky-600 py-0 my-0 font-semibold'> {$content} </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedQuoteDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['quote_id' => $quote_id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedQuoteDeletion')]
    public function onConfirmationQuoteDeletion($data)
    {
        if($data){

            $quote_id = $data['quote_id'];

            $quote = Quote::find($quote_id);

            if($quote){

                $quote->delete();

                $this->toast( "La citation  a été supprimée avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }



    #[On('LiveMemberQuotesUpdatedEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
}
