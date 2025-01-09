<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Member;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class MembersProfilComponent extends Component
{
    use Toast, Confirm;

    public $counter = 0;

    public $is_included = false;


    public function render()
    {
        $members = Member::all();
        
        $users = User::all();

        return view('livewire.master.members-profil-component', 
            [
                'members' => $members,
                'users' => $users,
            ]
        );
    }


    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
