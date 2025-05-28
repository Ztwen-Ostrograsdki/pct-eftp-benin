<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\ForumChat;
use Illuminate\Http\Request;
use Livewire\Component;

class ChatRoom extends Component
{
    public $messages;
    public $perPage = 3;

    protected $listeners = ['messageReceived' => 'loadMessages'];

    public function render()
    {
        return view('livewire.chat.chat-room');
    }

    
    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMore()
    {
        $this->perPage += 1;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = ForumChat::with('user')
            ->latest()
            ->take($this->perPage)
            ->get()
            ->reverse();
    }

    public function sendMessage(Request $request)
    {
        $user = auth_user();

        $data = $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')?->store('chat_files', 'public');

        $message = ForumChat::create([
            'user_id' => $user->id,
            'message' => $data['message'] ?? '',
            'file_path' => $path,
        ]);

        broadcast(new MessageSent($message))->toOthers();
    }

}
