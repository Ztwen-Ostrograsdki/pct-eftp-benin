<?php
namespace App\Helpers\LivewireTraits;

use Livewire\Attributes\On;

trait ListenToEchoEventsTrait{

	#[On("LiveRolePermissionsWasUpdatedEvent")]
    public function relaodDataForRolePermissionsUpdate()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveRoleUsersWasUpdatedEvent")]
    public function relaodDataForRoleUsersUpdate()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveUpdatedLyceesDataEvent")]
    public function relaodDataForLycees()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveUpdateMembersListEvent")]
    public function relaodDataForMembers()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveUpdateUsersListToComponentsEvent")]
    public function relaodDataForUsers()
    {
        $this->counter = getRandom();
    }


}

