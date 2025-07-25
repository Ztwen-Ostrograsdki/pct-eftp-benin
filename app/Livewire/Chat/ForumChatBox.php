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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Smalot\PdfParser\Parser;
use ZipArchive;

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

    public $is_image = false;

    public Collection $messages;
    public $perPage = 5;
    public $userId;
    public $earliestId;
    public $latestId;

    public function mount()
    {
        $this->userId = auth_user_id();
        
        $this->messages = collect();

        $this->loadInitialMessages();
    }

    protected function loadInitialMessages()
    {
        $messages = ForumChat::with('user')
            ->where(function ($query) {
                $query->whereNull('delete_by')
                      ->orWhereJsonDoesntContain('delete_by', $this->userId);
            })
            ->orderByDesc('created_at')
            ->take($this->perPage)
            ->get()
            ->reverse();

        $this->messages = $messages;
        $this->updateBoundaries();
    }

    public function loadMoreTop()
    {
        $older = ForumChat::with('user')
            ->where('id', '<', $this->earliestId)
            ->where(function ($query) {
                $query->whereNull('delete_by')
                      ->orWhereJsonDoesntContain('delete_by', $this->userId);
            })
            ->orderByDesc('created_at')
            ->take($this->perPage)
            ->get()
            ->reverse();

        $this->messages = $older->merge($this->messages);
        $this->updateBoundaries();
    }

    public function loadMoreBottom()
    {
        $newer = ForumChat::with('user')
            ->where('id', '>', $this->latestId)
            ->where(function ($query) {
                $query->whereNull('delete_by')
                      ->orWhereJsonDoesntContain('delete_by', $this->userId);
            })
            ->orderBy('created_at')
            ->take($this->perPage)
            ->get();

        $this->messages = $this->messages->merge($newer);
        $this->updateBoundaries();
    }

    protected function updateBoundaries()
    {
        $this->earliestId = $this->messages->first()?->id;
        $this->latestId = $this->messages->last()?->id;
    }

    public function getGroupedMessagesProperty()
    {
        return $this->messages->groupBy(function ($message) {
            return $message->created_at->format('Y-m-d');
        });
    }


    
    public function render()
    {

        // $allMessages = ForumChat::with('user')
        // ->where(function ($query) {
        //     $query->whereNull('delete_by')
        //         ->orWhereJsonDoesntContain('delete_by', auth_user_id());
        // })
        // ->orderBy('created_at')
        // ->get()
        // ->groupBy(function ($message) {
        //     return $message->created_at->format('Y-m-d');
        // });
    
        return view('livewire.chat.forum-chat-box');

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
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf,docx|max:8000',
            ]);

        }

        $message = trim($this->message);

        if(!$this->file){

            $data = [
                'user_id' => auth_user()->id,
                'message' => $message,
                'seen_by' => auth_user()->id,
                'reply_to_message_id' => $this->targeted_message_id,
            ];

            ForumChat::create($data);
            
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

            if($this->file->getSize() >= 1048580){

                $file_size = number_format($this->file->getSize() / 1048576, 2) . ' Mo';

            }
            else{

                $file_size = number_format($this->file->getSize() / 1000, 2) . ' Ko';

            }

            $message = trim($this->message);

            $user = auth_user();


            $file_saved_path = $this->file->storeAs("forum-media/", $file_name . '.' . $extension, ['disk' => 'public']);

            if($file_saved_path){

                if($this->file->getClientOriginalExtension() === 'pdf'){



                }
                elseif($this->file->getClientOriginalExtension() === 'docx' or $this->file->getClientOriginalExtension() === 'doc'){

                }
                else{

                    $this->total_pages = null;

                }

                $file_path_name = "forum-media/" . $file_name . '.' . $extension;

                $data = [
                    'user_id' => $user->id,
                    'message' => $message,
                    'seen_by' => $user->id,
                    'reply_to_message_id' => $this->targeted_message_id,
                    'file' => $originalNameWithoutExt,
                    'file_path' => $file_path_name,
                    'file_size' => $file_size,
                    'file_extension' => "." . $extension,
                    'file_pages' => $this->total_pages,
                ];

                ForumChat::create($data);

                // NewChatMessageIntoForumEvent::dispatchIf($data != [], $user, $data);

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

    #[On('LiveNewMessageHasBeenSentEvent')]
    public function insertNewMessage($message_id)
    {


    }

    public function reloadMessages($data = null)
    {
        $this->counter = getRand();
    }

    #[On('LiveForumChatSubjectHasBeenValidatedByAdminsEvent')]
    public function reloadMessagesForNewSubject($user = null)
    {
        $this->counter = getRand();

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


    public function downloadTheFile($chat_id)
    {
        $this->toast("Le téléchargement lancé... patientez", 'success');

        $chat = ForumChat::find($chat_id);

        if($chat){

            $path = $chat->file_path;

            if($path){

                $path = storage_path().'/app/public/' . $path;

                $exists = File::exists($path);
                
                if($exists){

                    $name = $chat->file . '' . $chat->file_extension;

                    return response()->download($path, $name);
                }
                else{

                    $this->toast("Le fichier n'a pas pu être téléchargé car le fichier est introuvable, peut être qu'il a déja été supprimé", 'error');

                }

            }
        }
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
        $this->reset('pdfPreviewPath', 'total_pages', 'is_image');

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

            $pageCount = null;
            
            $zip = new ZipArchive;

            if ($zip->open($tmpPath) === TRUE) {

                $xml = $zip->getFromName('docProps/app.xml');

                if ($xml !== false) {

                    $dom = new \DOMDocument();

                    $dom->loadXML($xml);

                    $pagesNode = $dom->getElementsByTagName('Pages')->item(0);

                    if ($pagesNode) {

                        $pageCount = (int) $pagesNode->nodeValue;
                    }
                }
                $zip->close();
            }

            // Valeur par défaut si non trouvée
            $pageCount = $pageCount ?? 1;

            $this->total_pages = $pageCount;

            $this->pdfPreviewPath = true;
        }
        else{

            $extension = strtolower($this->file->getClientOriginalExtension());

            $this->is_image = is_image($extension);

            $this->pdfPreviewPath = true;


        }


    }
     
}
