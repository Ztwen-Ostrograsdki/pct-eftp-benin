<?php

namespace App\Livewire\Master;

use App\Models\Communique;
use Livewire\Component;

class CommuniqueComponent extends Component
{
    public $communique_id;

    public function mount($id)
    {
        if($id){

            $communique = Communique::find($id);

            if(!$communique) return abort(404);

            else $this->communique_id = $id;


        }
        else{
            return abort(404);
        }

        
    }

    public function render()
    {
        $communique = Communique::find($this->communique_id);

        return view('livewire.master.communique-component', compact('communique'));
    }
}
