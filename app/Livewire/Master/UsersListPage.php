<?php

namespace App\Livewire\Master;

use App\Models\User;
use Livewire\Component;

class UsersListPage extends Component
{
    public function render()
    {
        $users = User::paginate(10);
        
        return view('livewire.master.users-list-page', compact('users'));
    }
}
