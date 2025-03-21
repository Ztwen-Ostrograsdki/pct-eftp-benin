<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Member;
use App\Models\User;
use Livewire\Component;

class CardMemberComponent extends Component
{

    use Toast, Confirm;

    public $identifiant;

    public $member_id;

    public $member;



    public function mount($identifiant)
    {
        if($identifiant){

            $this->identifiant = $identifiant;

        }
        else{

            return abort(404);

        }
    }


    public function render()
    {
        if($this->identifiant){

            $user = User::where('identifiant', $this->identifiant)->first();

            if($user && $user->member){

                $this->member = $user->member; 

                $this->member_id = $user->member->id; 

            }

        }
        return view('livewire.user.card-member-component');
    }

    public function sendCardToMember($member_id)
    {
        
    }
}
