<?php

namespace App\Livewire\Master;

use App\Models\Member;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des membres de l'association")]
class MembersListPage extends Component
{
    public function render()
    {
        $members = Member::all();
        
        $users = User::all();
        
        return view('livewire.master.members-list-page', 
            [
                'members' => $members,
                'users' => $users,
            ]
        );
    }
}
