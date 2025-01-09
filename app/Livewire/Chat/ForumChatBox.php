<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ForumChatBox extends Component
{
    public $message = '';
    
    public function render()
    {
        return view('livewire.chat.forum-chat-box');
    }


    public function sendMessage()
    {
        
    }


    public function resetMessage()
    {
        $this->reset('message');
    }
}
