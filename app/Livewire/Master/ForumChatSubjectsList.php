<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\ForumChatSubjectHasBeenValidatedByAdminsEvent;
use App\Helpers\Tools\SpatieManager;
use App\Models\ENotification;
use App\Models\ForumChatSubject;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class ForumChatSubjectsList extends Component
{
    use Toast, Confirm;

    public $search = '';

    public $counter = 1;

    public $forum_chat_subject_section = 'pending';

    public $sections = [
        'pending' => "En attente",
        'authorized' => "Validés",
        'closeds' => "fermés",
    ];

    #[On('LiveForumChatSubjectHasBeenClosedEvent')]
    public function reloadMessagesForClosedSubject($data = null)
    {
        $this->counter = getRandom();
    }

    #[On('LiveForumChatSubjectHasBeenLikedBySomeoneEvent')]
    public function reloadMessagesForSubjectLiked($data = null)
    {
        $this->counter = getRandom();
    }

    public function updatedForumChatSubjectSection($section)
    {
        session()->put('forum_chat_subject_section', $this->forum_chat_subject_section);
    }

    public function mount()
    {
        if(session()->has('forum_chat_subject_section')){

            $this->forum_chat_subject_section = session('forum_chat_subject_section');

        }
    }

    public function render()
    {
        $allSubjects = ForumChatSubject::all();

        if($this->forum_chat_subject_section){

            if($this->forum_chat_subject_section == 'pending'){

                $subjects = ForumChatSubject::where('authorized', false)->where('closed_at', null)->where('closed', false);
            }
            elseif($this->forum_chat_subject_section == 'authorized'){

                $subjects = ForumChatSubject::where('authorized', true)->where('closed_at', null)->where('closed', false);

            }
            elseif($this->forum_chat_subject_section == 'closeds'){

                $subjects = ForumChatSubject::where('authorized', true)->whereNotNull('closed_at')->where('closed', true);

            }
            else{

                $subjects = ForumChatSubject::where('id', '<>', 0);

            }
        }

        if($this->search && strlen($this->search) >= 3){

            $s = '%' . $this->search . '%';

            $subjects->where('subject', 'like', $s);

        }

        if(session()->has('forum_chat_subject_section')){

            $this->forum_chat_subject_section = session('forum_chat_subject_section');

        }

        return view('livewire.master.forum-chat-subjects-list', [
            'subjects' => $subjects->get(),
            'all_subjects' => $allSubjects
        ]);
    }

    public function searcher()
    {
        $this->search = $this->search;
    }

    public function validateSubject($subject_id)
    {
        SpatieManager::ensureThatUserCan(['forum-messages-manager']);
        
        $subject = ForumChatSubject::find($subject_id);

        $active_chat_subject = ForumChatSubject::where('active', true)->where('authorized', 1)->first();

        if($subject && !$subject->authorized){

            $closed_at = Carbon::now()->addHours(5);

            if($active_chat_subject){

                $validated = $subject->update([
                    'authorized' => true,
                    'active' => false,
                    'closed_at' => $closed_at,
                ]);

            }
            else{
                $validated = $subject->update([
                    'authorized' => true,
                    'closed_at' => $closed_at,
                ]);
            }

            if($validated && $subject->authorized){

                $user = $subject->user;

                $since = $subject->__getDateAsString($subject->created_at, 3, true);

                $updated_at = $subject->__getDateAsString($subject->updated_at, 3, true);

                $object = "Validation de votre sujet de discussion publié sur la plateforme le $since par les administrateurs!";

                $content = "Votre sujet de discussion a été validée ce $updated_at . Toutefois, si votre sujet n'apparait pas sur le forum veuillez patienter que les sujets en cours sur la plateforme soient traités et fermés! Votre sujet serait dans les files d'attentess";

                $title = "Validation d'un sujet de discussion publié";
                
                $data = [
                    'user_id' => auth_user()->id,
                    'content' => $content,
                    'title' => $title,
                    'object' => $object,
                    'receivers' => [$user->id]
                ];

                ENotification::create($data);

                ForumChatSubjectHasBeenValidatedByAdminsEvent::dispatch($subject->user);

            }

            $this->relaodData();

        }
    }

    public function deleteSubject($subject_id)
    {
        SpatieManager::ensureThatUserCan(['forum-messages-manager']);

        $subject = ForumChatSubject::find($subject_id);

        if($subject){

            $subject->delete();

            $this->relaodData();

        }
    }


    public function relaodData()
    {
        $this->counter = getRandom();
    }

    #[On('LiveForumChatSubjectHasBeenSubmittedToAdminsEvent')]
    public function newForumChatSubject()
    {
        $this->counter = getRandom();
    }


}
