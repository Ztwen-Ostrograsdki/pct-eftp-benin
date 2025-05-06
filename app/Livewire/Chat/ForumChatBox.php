<?php

namespace App\Livewire\Chat;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\ForumChatSubjectHasBeenClosedEvent;
use App\Events\ForumChatSubjectHasBeenLikedBySomeoneEvent;
use App\Events\NewChatMessageIntoForumEvent;
use App\Events\UserIsTypingMessageEvent;
use App\Events\YourMessageHasBeenLikedBySomeoneEvent;
use App\Models\ForumChat;
use App\Models\ForumChatSubject;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use App\Observers\ObserveChatForumMessage;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[ObservedBy(ObserveChatForumMessage::class)]
class ForumChatBox extends Component
{

    use Toast, Confirm;

    #[Rule('string|required')]
    public $message = '';

    public $onlines_users = 1;

    public $counter = 0;

    public $subject_show = true;

    public $targeted_message_id = null;

    public $targeted_message = null;


    
    public function render()
    {
        $active_chat_subject = ForumChatSubject::where('active', true)->where('authorized', 1)->first();

        $chats = ForumChat::all();

        return view('livewire.chat.forum-chat-box', [
            'active_chat_subject' => $active_chat_subject,
            'chats' => $chats,
        ]);

    }

    public function toggleSubject()
    {
        $this->subject_show = !$this->subject_show;
    }


    public function sendMessage()
    {
        $this->validate();

        $message = trim($this->message);

        $user = auth_user();

        $data = [
            'user_id' => auth_user()->id,
            'message' => $message,
            'seen_by' => auth_user()->id,
            'reply_to_message_id' => $this->targeted_message_id,
        ];
        
        NewChatMessageIntoForumEvent::dispatchIf($data != [], $user, $data);



        $this->reset();

        $this->message = '';
    }


    public function updatedMessage($message)
    {
        UserIsTypingMessageEvent::dispatchIf(strlen($message) > 3,  auth_user());
    }


    #[On('LiveUserIsTypingMessageEvent')]
    public function isTyping($user_data)
    {
        $user = new User($user_data);

        to_flash('typing', $user->getFullName());
    }

    #[On('LiveLoadNewMessageEvent')]
    public function reloadMessages($data = null)
    {
        $this->counter = rand(2, 23);
    }

    #[On('LiveForumChatSubjectHasBeenValidatedByAdminsEvent')]
    public function reloadMessagesForNewSubject($user = null)
    {
        $this->counter = rand(2, 23);

        $user = new User($user);

        $name = $user->getFullName();

        $this->toast("Un nouveau sujet de discussion a été publié sur le forum par $name", 'success');
    }
    
    #[On('LiveYourMessageHasBeenLikedBySomeoneEvent')]
    public function reloadMessagesForLikes($data = null)
    {
        $this->counter = rand(2, 23);
    }
    
    #[On('LiveForumChatSubjectHasBeenClosedEvent')]
    public function reloadMessagesForClosedSubject($data = null)
    {
        $this->counter = rand(2, 23);
    }
    
    #[On('LiveForumChatSubjectHasBeenLikedBySomeoneEvent')]
    public function reloadMessagesForSubjectLiked($data = null)
    {
        $this->counter = rand(2, 23);
    }
    
    #[On('LiveConnectedUsersToForumEvent')]
    public function getConnectedUsers($users = null)
    {
        $this->onlines_users = count($users);
    }

    #[On('LiveForumChatSubjectHasBeenSubmittedToAdminsEvent')]
    public function forumChatSubjectSubmitted($user = null)
    {
        $this->counter = rand(2, 23);

        $this->toast("Votre sujet a été soumis avec succes aux administrateurs!", 'success');
    }
    
    public function deleteMessage($message_id)
    {
        $user_id = auth_user()->id;

        $chat = ForumChat::find($message_id);

        if($chat){

            $delete_by = (array)$chat->delete_by;

            if(!in_array($user_id, $delete_by)){

                $delete_by[] = $user_id;

                $chat->update(['delete_by' => $delete_by]);

                $this->reloadMessages();

            }
        }
    }

    public function likeMessage($message_id)
    {
        $user_id = auth_user()->id;

        $chat = ForumChat::find($message_id);

        if($chat){

            $name = $chat->user->getFullName();

            $likes = (array)$chat->likes;

            if(!in_array($user_id, $likes)){

                $likes[] = $user_id;

                $chat->update(['likes' => $likes]);

                YourMessageHasBeenLikedBySomeoneEvent::dispatch(auth_user(), $chat->user);

                if($user_id !== $chat->user->id){

                    $liker_name = auth_user_fullName();

                    $chat->user->notify(new RealTimeNotificationGetToUser($liker_name . " a aimé votre message dans le forum!"));
                }

                $this->toast("Vous avez aimé le message de $name!", 'success');
            }
            else{

                $key = array_keys($likes, $user_id);

                unset($likes[$key[0]]);

                $chat->update(['likes' => $likes]);

                $this->reloadMessages();

            }
        }
    }

    public function replyToMessage($message_id)
    {
        $this->targeted_message_id = $message_id;

        $this->targeted_message = ForumChat::find($message_id);


    }

    public function cancelReply()
    {
        $this->targeted_message_id = null;
    }



    public function deleteSubject($subject_id = null)
    {
        $active_chat_subject = ForumChatSubject::where('active', true)->where('authorized', 1)->first();

        if($active_chat_subject){

            $closed = $active_chat_subject->update(['closed' => true, 'active' => false]);

            if($closed){

                ForumChatSubjectHasBeenClosedEvent::dispatch();
            }

        }
    }

    public function likeSubject($subject_id = null)
    {
        $user_id = auth_user()->id;

        $active_chat_subject = ForumChatSubject::where('active', true)->where('authorized', 1)->first();

        if($active_chat_subject){

            $name = $active_chat_subject->user->getFullName();

            $likes = (array)$active_chat_subject->likes;

            if(!in_array($user_id, $likes)){

                $likes[] = $user_id;

                $active_chat_subject->update(['likes' => $likes]);

                ForumChatSubjectHasBeenLikedBySomeoneEvent::dispatch(auth_user(), $active_chat_subject->user);

                $this->toast("Vous avez aimé ce topic de $name!", 'success');

            }
            else{

                $key = array_keys($likes, $user_id);

                unset($likes[$key[0]]);

                $active_chat_subject->update(['likes' => $likes]);

                $this->reloadMessages();

            }
        }
    }



    public function resetMessage()
    {
        $this->message = '';
    }

    public function addNewChatSubject()
    {
        $this->dispatch('OpenModalForNewForumChatSubject');
    }
}
