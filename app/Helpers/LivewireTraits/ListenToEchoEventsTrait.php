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


}

