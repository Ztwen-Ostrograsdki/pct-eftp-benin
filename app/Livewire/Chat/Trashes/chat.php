<?php
namespace App\Livewire\Chat\Trashes;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models\ForumChat;

class ChatComponent extends Component
{
    public $conversationId;
    public $messages;
    public $newMessage = '';
    public $sendingMessages = [];

    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
        
        $this->messages = ForumChat::where('conversation_id', $conversationId)
            ->latest()
            ->take(30)
            ->get()
            ->reverse()
            ->values();
    }

    protected $rules = [
        'newMessage' => 'required|string|max:1000',
    ];

    public function render()
    {
        return view('livewire.chat-component');
    }

	public function sendMessage()
{
    $this->validate([
        'newMessage' => 'required|string|max:1000',
    ]);

    $tempId = 'temp_' . Str::random(8);

    // Message temporaire (affiché tout de suite)
    $this->sendingMessages[] = [
        'id' => $tempId,
        'body' => $this->newMessage,
        'status' => 'sending',
        'user_id' => auth_user()->id,
        'created_at' => now()->toDateTimeString(),
    ];

    $messageContent = $this->newMessage;
    $this->newMessage = '';

    // Enregistrement en base
    $message = ForumChat::create([
        'body' => $messageContent,
        'user_id' => auth_user_id(),
        'conversation_id' => $this->conversationId,
    ]);

    // Broadcast aux autres utilisateurs
    broadcast(new MessageSent($message))->toOthers();

    // Ajouter le vrai message dans la liste
    $this->messages->push($message);

    // Retirer le message temporaire
    $this->sendingMessages = array_filter(
        $this->sendingMessages,
        fn($msg) => $msg['id'] !== $tempId
    );
}
}