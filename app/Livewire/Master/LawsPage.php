<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\ForumChatSubject;
use Livewire\Component;

class LawsPage extends Component
{
    use Toast, Confirm;

    public $search = '';

    public $counter = 1;

    public $laws_section_selected = 'pending';

    public $sections = [
        'pending' => "En attente",
        'authorized' => "Validés",
        'closeds' => "fermés",
    ];


    public function updatedForumChatSubjectSection($section)
    {
        session()->put('laws_section_selected', $this->laws_section_selected);
    }

    public function mount()
    {
        if(session()->has('laws_section_selected')){

            $this->laws_section_selected = session('laws_section_selected');

        }
    }

    public function render()
    {
        $allSubjects = ForumChatSubject::all();

        if($this->laws_section_selected){

            if($this->laws_section_selected == 'pending'){

                $subjects = ForumChatSubject::where('authorized', false)->where('closed_at', null)->where('closed', false);
            }
            elseif($this->laws_section_selected == 'authorized'){

                $subjects = ForumChatSubject::where('authorized', true)->where('closed_at', null)->where('closed', false);

            }
            elseif($this->laws_section_selected == 'closeds'){

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

        if(session()->has('laws_section_selected')){

            $this->laws_section_selected = session('laws_section_selected');

        }

        return view('livewire.master.laws-page', [
            'subjects' => $subjects->paginate(3),
            'all_subjects' => $allSubjects
        ]);
    }

    public function searcher()
    {
        $this->search = $this->search;
    }

    public function newLaw()
    {
        $this->dispatch("OpenLawManagerModal");
    }

    public function deleteSubject($subject_id)
    {
        
    }


    public function relaodData()
    {
        $this->counter = getRandom();
    }

   


}

