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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Smalot\PdfParser\Parser;

#[ObservedBy(ObserveChatForumMessage::class)]
class ForumChatBox extends Component
{

    use Toast, Confirm, WithFileUploads;

    #[Rule('string|required')]
    public $message = '';

    public $onlines_users = 1;

    public $counter = 0;

    public $subject_show = true;

    public $targeted_message_id = null;

    public $targeted_message = null;

    public $file;

    public $pdfPreviewPath;

    public $total_pages = 1;


    
    public function render()
    {
        $active_chat_subject = ForumChatSubject::where('active', true)->where('authorized', 1)->first();

        $chats = ForumChat::all();

        $allMessages = ForumChat::orderBy('created_at')->get()->groupBy(function ($message){

            return $message->created_at->format('Y-m-d');

        });

        return view('livewire.chat.forum-chat-box', [
            'active_chat_subject' => $active_chat_subject,
            'chats' => $chats,
            'allMessages' => $allMessages
        ]);

    }

    public function toggleSubject()
    {
        $this->subject_show = !$this->subject_show;
    }


    public function sendMessage()
    {
        
        if(!$this->file){

            $this->validate();
        }
        else{

            $validated = $this->validate([ 
                'file' => 'required|file|mimes:docx,pdf|max:8000',
            ]);

        }

        $message = trim($this->message);

        $user = auth_user();

        if(!$this->file){

            $data = [
                'user_id' => auth_user()->id,
                'message' => $message,
                'seen_by' => auth_user()->id,
                'reply_to_message_id' => $this->targeted_message_id,
            ];
            
            NewChatMessageIntoForumEvent::dispatchIf($data != [], $user, $data);
        }
        else{

            self::messageWithFileManager();

        }

        $this->reset();

        $this->message = '';
    }

    public function messageWithFileManager()
    {
        $file_size = '0 Ko';

        if($this->file){

            $extension = $this->file->extension();

            $originalNameWithoutExt = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);

            $file_name = 'forum-doc-' . getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'] . '-' .  Str::lower(Str::random(8));

            $root = storage_path("app/public/forum-media/");

            if(!File::isDirectory($root)){

                File::makeDirectory($root, 0777, true, true);

            }

            $path = storage_path("app/public/forum-media/" . $file_name . "." . $extension);

            if($this->file->getSize() >= 1048580){

                $file_size = number_format($this->file->getSize() / 1048576, 2) . ' Mo';

            }
            else{

                $file_size = number_format($this->file->getSize() / 1000, 2) . ' Ko';

            }

            $message = trim($this->message);

            $user = auth_user();


            $file_saved_path = $this->file->storeAs("forum-documents/", $file_name . '.' . $extension, ['disk' => 'public']);

            if($file_saved_path){

                $tmpPath = $this->file->getRealPath();

                // Analyse le fichier temporaire
                $parser = new Parser();

                $pdf = $parser->parseFile($tmpPath);

                $details = $pdf->getDetails();

                $pageCount = $details['Pages'] ?? 1;

                $data = [
                    'user_id' => $user->id,
                    'message' => $message,
                    'seen_by' => $user->id,
                    'reply_to_message_id' => $this->targeted_message_id,
                    'file' => $originalNameWithoutExt,
                    'file_path' => $path,
                    'file_size' => $file_size,
                    'file_extension' => "." . $extension,
                    'file_pages' => $pageCount,
                ];

                NewChatMessageIntoForumEvent::dispatchIf($data != [], $user, $data);

                $this->reset();
            }
            else{

                $this->toast("Une erreure est survenue", 'error');
            }

        }

        
    }


    public function updatedMessage($message)
    {
        // UserIsTypingMessageEvent::dispatchIf(strlen($message) > 3,  auth_user());
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

                if(true){

                    $liker_name = auth_user_fullName();

                    Notification::sendNow([$chat->user], new RealTimeNotificationGetToUser($liker_name . " a aimé votre message dans le forum!","message.liked"));

                    // $chat->user->notify(new RealTimeNotificationGetToUser($liker_name . " a aimé votre message dans le forum!", $chat->user));
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


    public function downloadFile($fullpath)
    {
        
    }



    public function deleteFile()
    {
        $this->reset('file', 'pdfPreviewPath');
    }
    
    public function resetMessage()
    {
        $this->message = '';
    }

    public function addNewChatSubject()
    {
        $this->dispatch('OpenModalForNewForumChatSubject');
    }

    public function updatedFile()
    {
        // Réinitialiser l’aperçu si nouveau fichier
        $this->reset('pdfPreviewPath', 'total_pages');

        if ($this->file && $this->file->getClientOriginalExtension() === 'pdf') {

            $tmpPath = $this->file->getRealPath();

            $parser = new Parser();

            $pdf = $parser->parseFile($tmpPath);

            $details = $pdf->getDetails();

            $pageCount = $details['Pages'] ?? 1;

            $this->total_pages = $pageCount;

            $this->pdfPreviewPath = true;
        }

        if ($this->file &&  $this->file->getClientOriginalExtension() === 'docx' or $this->file->getClientOriginalExtension() === 'doc') {

            $tmpPath = $this->file->getRealPath();

            $this->total_pages = 2;

            $this->pdfPreviewPath = true;
        }
    }
     
}
