<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Livewire\Component;

class CardModule extends Component
{
    use Toast, Confirm;

    public $identifiant;

    public $member_id;

    public $member;

    public function render()
    {
        if($this->identifiant){

            $user = User::where('identifiant', $this->identifiant)->first();

            if($user && $user->member){

                $this->member = $user->member; 

                $this->member_id = $user->member->id; 

            }

        }
        return view('livewire.user.card-module');
    }

    
}
