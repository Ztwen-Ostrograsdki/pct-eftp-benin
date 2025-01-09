<?php

namespace App\Livewire\Master;

use Livewire\Attributes\On;
use Livewire\Component;

class MembersHomePage extends Component
{
    public $member_section = 'list';

    public $member_section_title = 'liste';

    public $counter = 2;

    public $member_sections = [
        'members-list' => "Liste",
        'users-list' => "Les enseignants",
        'members' => "Les membres",
        'roles' => "Les Fonctions",
        'info' => "Les Communiqués",
        "lays" => "Les réglements intérieurs",
        "history" => "Historique",
        'cv' => "CV de l'association"

    ];

    public function updatedMemberSection($section)
    {
        session()->put('member_section', $this->member_section);
    }

    public function mount()
    {
        if(session()->has('member_section')){

            $this->member_section = session('member_section');

        }
    }

    public function render()
    {
        if(session()->has('member_section')){

            $this->member_section = session('member_section');

        }

        return view('livewire.master.members-home-page');
    }


    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
