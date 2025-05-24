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

   
    #[On('UpdatedCommuniquesList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }

    public function sendCommuniqueToMemberByEmail($communique_id)
    {

        $admin_generator = auth_user();

        $communique = Communique::find($communique_id);

        if($communique){

            $event = InitProcessToSendCommuniqueToMembersByMailEvent::dispatch($admin_generator, $communique, null);

            
        }
    }

}
