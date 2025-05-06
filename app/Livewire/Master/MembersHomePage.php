<?php

namespace App\Livewire\Master;

use Livewire\Attributes\On;
use Livewire\Component;

class MembersHomePage extends Component
{
    public $member_section = 'users-list';

    public $member_section_title = 'liste';

    public $counter = 2;

    public $member_sections = [
        'members-list' => "Liste",
        'members-cards' => "Cartes de membres",
        'users-list' => "Les enseignants",
        'members' => "Les membres",
        'roles' => "Les Fonctions",
        'lycees' => "Les Lycées",
        'laws' => "Les Lois",
        'subjects' => "Les Sujets de discussion",
        'info' => "Les Communiqués",
        'epreuves' => "Les Epreuves",
        'epreuves-exams-list' => "Les Epreuves d'examens",
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

    #[On('LiveUpdateLawEcosystemEvent')]
    public function reloadLawData()
    {
        $this->counter = getRandom();
    }


    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = getRandom();
    }
}
