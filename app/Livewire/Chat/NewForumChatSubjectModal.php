<?php

namespace App\Livewire\Chat;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\NewForumChatSubjectDispachedByUserEvent;
use App\Models\ForumChatSubject;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewForumChatSubjectModal extends Component
{
    use Toast, Confirm;

    public $modal_name = "#new-forum-chat-subject-modal";

    #[Validate('required|string')]
    public $content = '';

    public function render()
    {
        return view('livewire.chat.new-forum-chat-subject-modal');
    }

    #[On('OpenModalForNewForumChatSubject')]
    public function openModal()
    {

        $active_subject = ForumChatSubject::where('active', 1)->where('closed', false)->where('authorized', true)->first();

        if($active_subject) 
            return $this->toast("Il y a un sujet de discussion en cours. Le sujet de discussion en cours doit être fermé avant de lancer un autre sujet", 'warning');
        
        else

            $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function insert()
    {
        $this->validate();

        $data = [
            'user_id' => auth_user()->id,
            'subject' => $this->content,
        ];

        NewForumChatSubjectDispachedByUserEvent::dispatch(auth_user(), $data);

        $this->hideModal();
    }
}
