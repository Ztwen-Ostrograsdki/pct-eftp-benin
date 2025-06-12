<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Tools\SpatieManager;
use Livewire\Attributes\On;
use Livewire\Component;

class MembersHomePage extends Component
{
    use ListenToEchoEventsTrait;

    public $member_section = null;

    public $member_section_title = 'liste';

    public $counter = 2;

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
        $member_sections = [];

        if(session()->has('member_section')){

            $this->member_section = session('member_section');

        }

        $member_sections = SpatieManager::getUserDashboard();

        if($member_sections){

            if($this->member_section == null){

                $this->member_section = array_key_first($member_sections);
            }

        }

        return view('livewire.master.members-home-page', compact('member_sections'));
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

    public function joinMemberToRole()
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $this->dispatch('OpenModalToJoinMemberToRole');
    }

    
}
