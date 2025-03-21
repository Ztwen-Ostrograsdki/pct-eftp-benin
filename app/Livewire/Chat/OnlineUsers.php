<?php

namespace App\Livewire\Chat;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class OnlineUsers extends Component
{
    public $onlines_users = [];

    public $users = [];

    public function render()
    {
        return view('livewire.chat.online-users');
    }

    #[On('LiveConnectedUsersToForumEvent')]
    public function getConnectedUsers($users = null)
    {
        $this->onlines_users = $users;

        $onlines = [];

        if(count($this->onlines_users)){

            foreach($this->onlines_users as $u){
                
                $us = User::find($u['id']);

                if($us && $us->id !== auth_user()->id) $onlines[] = $us;
            }

        }

        $this->users = $onlines;


    }
}
